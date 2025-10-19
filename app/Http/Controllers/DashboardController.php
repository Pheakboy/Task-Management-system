<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $projects = Project::with('tasks')->latest()->get();
        } else {
            $projects = $user->projects()->with('tasks')->latest()->get();
        }

        // Calculate task statistics
        $projectsWithStats = $projects->map(function ($project) {
            return [
                'project' => $project,
                'stats' => $project->taskCountsByStatus(),
            ];
        });
        
        return view('dashboard', ['projectsWithStats' => $projectsWithStats]);
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
