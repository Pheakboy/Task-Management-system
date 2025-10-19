<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $task->title }}
            </h2>
            <div class="flex gap-2">
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Edit
                    </a>
                @endcan
                @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Delete this task?');">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <p class="mt-1 text-gray-900 text-lg">{{ $task->title }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <div class="mt-1">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $task->status === 'todo' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $task->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $task->status === 'done' ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ str_replace('_', ' ', ucfirst($task->status)) }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Project</label>
                            <p class="mt-1 text-gray-900">
                                <a href="{{ route('projects.show', $task->project) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $task->project->name }}
                                </a>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Assigned To</label>
                            <p class="mt-1 text-gray-900">{{ $task->assignedUser->name }}</p>
                        </div>

                        @if($task->due_date)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Due Date</label>
                                <p class="mt-1 text-gray-900 {{ $task->due_date->isPast() && $task->status !== 'done' ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $task->due_date->format('F d, Y') }}
                                    @if($task->due_date->isPast() && $task->status !== 'done')
                                        (Overdue)
                                    @endif
                                </p>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Created</label>
                            <p class="mt-1 text-gray-900">{{ $task->created_at->format('M d, Y g:i A') }}</p>
                        </div>
                    </div>

                    @if($task->description)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <p class="mt-1 text-gray-900 whitespace-pre-wrap">{{ $task->description }}</p>
                        </div>
                    @endif

                    @can('update', $task)
                        <div class="mt-6 pt-6 border-t">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Quick Status Update</label>
                            <form action="{{ route('tasks.updateStatus', $task) }}" method="POST" class="flex gap-2">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="status" value="todo" class="px-4 py-2 rounded {{ $task->status === 'todo' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                    To Do
                                </button>
                                <button type="submit" name="status" value="in_progress" class="px-4 py-2 rounded {{ $task->status === 'in_progress' ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-800 hover:bg-blue-200' }}">
                                    In Progress
                                </button>
                                <button type="submit" name="status" value="done" class="px-4 py-2 rounded {{ $task->status === 'done' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                                    Done
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('projects.show', $task->project) }}" class="text-indigo-600 hover:text-indigo-900">
                    ← Back to Project
                </a>
                <a href="{{ route('tasks.index') }}" class="text-indigo-600 hover:text-indigo-900">
                    All Tasks
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
