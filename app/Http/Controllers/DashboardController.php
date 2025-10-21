<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        
        // Admin gets different dashboard
        if ($user->isAdmin()) {
            return $this->adminDashboard($request);
        }
        
        // Regular user dashboard
        return $this->userDashboard($request);
    }

    /**
     * Admin dashboard with system overview
     */
    private function adminDashboard(Request $request): View
    {
        // System statistics
        $totalUsers = User::count();
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $tasksInProgress = Task::where('status', 'in_progress')->count();
        $tasksDone = Task::where('status', 'done')->count();
        $tasksTodo = Task::where('status', 'todo')->count();
        
        // Recent projects
        $recentProjects = Project::with('user')->latest()->take(5)->get();
        
        // Get all projects with tasks
        $projectsQuery = Project::with(['tasks', 'user']);
        
        // Apply filters
        if ($request->filled('project_search')) {
            $projectsQuery->where('name', 'like', '%' . $request->project_search . '%');
        }
        
        $projects = $projectsQuery->latest()->get();
        
        // Calculate task statistics
        $projectsWithStats = $projects->map(function ($project) {
            return [
                'project' => $project,
                'stats' => $project->taskCountsByStatus(),
            ];
        });
        
        // Get users for filters
        $users = User::all();
        $statuses = ['todo', 'in_progress', 'done'];
        
        // User activity - projects per user
        $userActivity = User::withCount('projects')->get();
        
        // Recent tasks
        $recentTasks = Task::with(['project', 'assignedUser'])->latest()->take(10)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProjects',
            'totalTasks',
            'tasksInProgress',
            'tasksDone',
            'tasksTodo',
            'recentProjects',
            'projectsWithStats',
            'users',
            'statuses',
            'userActivity',
            'recentTasks'
        ));
    }

    /**
     * Regular user dashboard
     */
    private function userDashboard(Request $request): View
    {
        $user = Auth::user();
        
        // Get user's projects with tasks
        $projectsQuery = $user->projects()->with('tasks');
        
        // Apply filters
        if ($request->filled('project_search')) {
            $projectsQuery->where('name', 'like', '%' . $request->project_search . '%');
        }
        
        $projects = $projectsQuery->latest()->get();
        
        // Calculate task statistics
        $projectsWithStats = $projects->map(function ($project) {
            return [
                'project' => $project,
                'stats' => $project->taskCountsByStatus(),
            ];
        });
        
        // Get users for filters
        $users = User::all();
        $statuses = ['todo', 'in_progress', 'done'];
        
        return view('dashboard', compact('projectsWithStats', 'users', 'statuses'));
    }

    /**
     * Display the admin dashboard.
     */
    public function admin(): View
    {
        $projects = Project::with('tasks')->latest()->get();

        $projectsWithStats = $projects->map(function ($project) {
            return [
                'project' => $project,
                'stats' => $project->taskCountsByStatus(),
            ];
        });

        return view('admin.dashboard', ['projectsWithStats' => $projectsWithStats]);
    }
}
