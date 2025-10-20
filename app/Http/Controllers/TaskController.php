<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Task::with(['project', 'assignedUser']);

        // Scope by user role - users see tasks in their own projects
        if (!$user->isAdmin()) {
            $query->whereHas('project', function ($q) use ($user) {
                $q->where('created_by', $user->id);
            });
        }

        // Filter by project
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by assigned user
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Search by task title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->latest()->paginate(15)->withQueryString();

        // Get filter options
        $projects = $user->isAdmin()
            ? Project::all()
            : Project::where('created_by', $user->id)->get();

        $users = User::all();
        $statuses = ['todo', 'in_progress', 'done'];

        return view('tasks.index', compact('tasks', 'projects', 'users', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $projectId = $request->get('project_id');

        // Get projects user can create tasks in
        $projects = $user->isAdmin()
            ? Project::all()
            : Project::where('created_by', $user->id)->get();

        // Get all users for assignment (both admin and regular users can assign to anyone)
        $users = User::all();

        return view('tasks.create', compact('projects', 'users', 'projectId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assigned_to' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:todo,in_progress,done'],
            'due_date' => ['nullable', 'date'],
        ]);

        // Check if user owns the project (unless admin)
        if (!$user->isAdmin()) {
            $project = Project::findOrFail($validated['project_id']);
            if ($project->created_by !== $user->id) {
                abort(403, 'You can only create tasks in your own projects.');
            }
        }

        $task = Task::create($validated);

        return redirect()->route('projects.show', $task->project_id)
            ->with('status', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['project', 'assignedUser']);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $user = Auth::user();

        $projects = $user->isAdmin()
            ? Project::all()
            : Project::where('created_by', $user->id)->get();

        // Get all users for assignment (both admin and regular users can assign to anyone)
        $users = User::all();

        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assigned_to' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:todo,in_progress,done'],
            'due_date' => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return redirect()->route('tasks.show', $task)
            ->with('status', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $projectId = $task->project_id;
        $task->delete();

        return redirect()->route('projects.show', $projectId)
            ->with('status', 'Task deleted successfully.');
    }

    /**
     * Update task status quickly.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'status' => ['required', 'in:todo,in_progress,done'],
        ]);

        $task->update(['status' => $validated['status']]);

        return back()->with('status', 'Task status updated.');
    }
}
