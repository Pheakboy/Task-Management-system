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
        $projectId = $request->get('project_id');

        $query = Task::with(['project', 'assignedUser']);

        // Filter by project if specified
        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        // Scope by user role
        if (!$user->isAdmin()) {
            $query->whereHas('project', function ($q) use ($user) {
                $q->where('created_by', $user->id);
            });
        }

        $tasks = $query->latest()->paginate(15);

        return view('tasks.index', compact('tasks'));
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

        // Get users for assignment - admin sees all, regular users see only themselves
        $users = $user->isAdmin()
            ? User::all()
            : User::where('id', $user->id)->get();

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
            
            // Regular users can only assign tasks to themselves
            if ($validated['assigned_to'] !== $user->id) {
                abort(403, 'You can only assign tasks to yourself.');
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

        // Get users for assignment - admin sees all, regular users see only themselves
        $users = $user->isAdmin()
            ? User::all()
            : User::where('id', $user->id)->get();

        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
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

        // Regular users can only assign tasks to themselves
        if (!$user->isAdmin() && $validated['assigned_to'] !== $user->id) {
            abort(403, 'You can only assign tasks to yourself.');
        }

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
