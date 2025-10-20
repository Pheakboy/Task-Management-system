<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $projects = $user->isAdmin()
            ? Project::latest()->paginate(10)
            : Project::where('created_by', $user->id)->latest()->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Get users for assignment - only admins can assign projects to others
        $users = $user->isAdmin() 
            ? \App\Models\User::all()
            : collect([]);

        return view('projects.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'created_by' => ['nullable', 'exists:users,id'],
        ]);

        // If admin and created_by is provided, use it. Otherwise use current user
        $createdBy = $user->isAdmin() && $request->filled('created_by')
            ? $validated['created_by']
            : Auth::id();

        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'created_by' => $createdBy,
        ]);

        return redirect()->route('projects.show', $project)->with('status', 'Project created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $user = Auth::user();
        
        // Get users for assignment - only admins can reassign projects
        $users = $user->isAdmin() 
            ? \App\Models\User::all()
            : collect([]);

        return view('projects.edit', compact('project', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'created_by' => ['nullable', 'exists:users,id'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ];

        // Only admin can change project owner
        if ($user->isAdmin() && $request->filled('created_by')) {
            $updateData['created_by'] = $validated['created_by'];
        }

        $project->update($updateData);

        return redirect()->route('projects.show', $project)->with('status', 'Project updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('status', 'Project deleted.');
    }
}
