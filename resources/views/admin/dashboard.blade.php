<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin Dashboard
            </h2>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                New Project
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-2">Welcome, Administrator!</h3>
                    <p class="text-gray-600">You have full access to all projects and tasks in the system.</p>
                </div>
            </div>

            <!-- System Overview Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Users</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\User::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Projects</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Project::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Tasks</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Task::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">In Progress</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Task::where('status', 'in_progress')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- All Projects with Task Stats -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">All Projects</h3>

                    @if($projectsWithStats->count() > 0)
                        <div class="space-y-4">
                            @foreach($projectsWithStats as $item)
                                @php
                                    $project = $item['project'];
                                    $stats = $item['stats'];
                                    $total = array_sum($stats);
                                @endphp
                                <div class="border rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-semibold text-lg">
                                                <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $project->name }}
                                                </a>
                                            </h4>
                                            <p class="text-sm text-gray-600 mt-1">Owner: {{ $project->user->name }}</p>
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $project->created_at->format('M d, Y') }}</span>
                                    </div>

                                    <!-- Task Status Breakdown -->
                                    <div class="flex gap-4 mt-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-2xl font-bold text-gray-900">{{ $total }}</span>
                                            <span class="text-sm text-gray-600">Total Tasks</span>
                                        </div>
                                        <div class="flex-1 flex items-center gap-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                                                <span class="text-sm text-gray-600">{{ $stats['todo'] }} To Do</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                                <span class="text-sm text-gray-600">{{ $stats['in_progress'] }} In Progress</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                                <span class="text-sm text-gray-600">{{ $stats['done'] }} Done</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    @if($total > 0)
                                        <div class="mt-4 bg-gray-200 rounded-full h-2 overflow-hidden">
                                            <div class="h-full flex">
                                                @if($stats['done'] > 0)
                                                    <div class="bg-green-500" style="width: {{ ($stats['done'] / $total) * 100 }}%"></div>
                                                @endif
                                                @if($stats['in_progress'] > 0)
                                                    <div class="bg-blue-500" style="width: {{ ($stats['in_progress'] / $total) * 100 }}%"></div>
                                                @endif
                                                @if($stats['todo'] > 0)
                                                    <div class="bg-gray-400" style="width: {{ ($stats['todo'] / $total) * 100 }}%"></div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No projects in the system yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
