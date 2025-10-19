<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tasks') }}
            </h2>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Create Task
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($tasks->count() > 0)
                        <!-- Tasks grouped by status -->
                        @php
                            $tasksByStatus = $tasks->groupBy('status');
                        @endphp

                        @foreach(['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'] as $status => $label)
                            @if($tasksByStatus->has($status))
                                <div class="mb-8">
                                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                                        <span class="px-3 py-1 rounded-full text-sm 
                                            {{ $status === 'todo' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $status === 'done' ? 'bg-green-100 text-green-800' : '' }}">
                                            {{ $label }} ({{ $tasksByStatus[$status]->count() }})
                                        </span>
                                    </h3>

                                    <div class="space-y-4">
                                        @foreach($tasksByStatus[$status] as $task)
                                            <div class="border rounded-lg p-4 hover:shadow-md transition">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <h4 class="font-semibold text-lg">
                                                            <a href="{{ route('tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900">
                                                                {{ $task->title }}
                                                            </a>
                                                        </h4>
                                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($task->description, 100) }}</p>
                                                        <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                                                            <span>📁 {{ $task->project->name }}</span>
                                                            <span>👤 {{ $task->assignedUser->name }}</span>
                                                            @if($task->due_date)
                                                                <span class="{{ $task->due_date->isPast() && $task->status !== 'done' ? 'text-red-600 font-semibold' : '' }}">
                                                                    📅 {{ $task->due_date->format('M d, Y') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-2 ml-4 shrink-0">
                                                        @can('update', $task)
                                                            <a
                                                                href="{{ route('tasks.edit', $task) }}"
                                                                title="Edit task"
                                                                class="group inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-xs font-semibold text-white bg-gradient-to-r from-indigo-500 to-violet-600 shadow-sm hover:shadow-md hover:from-indigo-600 hover:to-violet-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 active:scale-[.98] transition"
                                                            >
                                                                <span class="opacity-90 group-hover:opacity-100">✏️</span>
                                                                <span>Edit</span>
                                                            </a>
                                                        @endcan
                                                        @can('delete', $task)
                                                            <form
                                                                action="{{ route('tasks.destroy', $task) }}"
                                                                method="POST"
                                                                class="inline"
                                                                onsubmit="return confirm('Delete this task?');"
                                                            >
                                                                @csrf
                                                                @method('DELETE')
                                                                <button
                                                                    type="submit"
                                                                    title="Delete task"
                                                                    class="group inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-xs font-semibold text-white bg-gradient-to-r from-rose-500 to-red-600 shadow-sm hover:shadow-md hover:from-rose-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-500/40 active:scale-[.98] transition"
                                                                >
                                                                    <span class="opacity-90 group-hover:opacity-100">🗑️</span>
                                                                    <span>Delete</span>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <div class="mt-6">
                            {{ $tasks->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No tasks found. <a href="{{ route('tasks.create') }}" class="text-indigo-600 hover:text-indigo-900">Create your first task</a>.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
