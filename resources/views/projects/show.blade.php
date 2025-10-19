<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }}
            </h2>
            <div class="flex gap-2">
                @can('update', $project)
                    <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Edit
                    </a>
                @endcan
                @can('delete', $project)
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this project?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Tasks List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Tasks</h3>
                        <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="inline-flex items-center px-3 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Add Task
                        </a>
                    </div>

                    @if($project->tasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($project->tasks as $task)
                                <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-semibold">
                                                <a href="{{ route('tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $task->title }}
                                                </a>
                                            </h4>
                                            <div class="mt-2 flex items-center gap-4 text-sm">
                                                <span class="px-2 py-1 rounded text-xs font-semibold
                                                    {{ $task->status === 'todo' ? 'bg-gray-100 text-gray-800' : '' }}
                                                    {{ $task->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $task->status === 'done' ? 'bg-green-100 text-green-800' : '' }}">
                                                    {{ str_replace('_', ' ', ucfirst($task->status)) }}
                                                </span>
                                                <span class="text-gray-600">👤 {{ $task->assignedUser->name }}</span>
                                                @if($task->due_date)
                                                    <span class="text-gray-600 {{ $task->due_date->isPast() && $task->status !== 'done' ? 'text-red-600 font-semibold' : '' }}">
                                                        📅 {{ $task->due_date->format('M d') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No tasks yet. <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="text-indigo-600 hover:text-indigo-900">Create the first task</a>.</p>
                    @endif
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('projects.index') }}" class="text-indigo-600 hover:text-indigo-900">
                    ← Back to Projects
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
