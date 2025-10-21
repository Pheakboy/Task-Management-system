<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Admin Control Panel
                </h2>
                <p class="text-sm text-gray-600 mt-1">Complete system overview and management</p>
            </div>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Project
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- System Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium uppercase">Total Users</p>
                                <p class="text-4xl font-bold mt-2">{{ $totalUsers }}</p>
                            </div>
                            <div class="bg-blue-400 bg-opacity-30 p-3 rounded-full">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Projects -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium uppercase">Total Projects</p>
                                <p class="text-4xl font-bold mt-2">{{ $totalProjects }}</p>
                            </div>
                            <div class="bg-green-400 bg-opacity-30 p-3 rounded-full">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Tasks -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium uppercase">Total Tasks</p>
                                <p class="text-4xl font-bold mt-2">{{ $totalTasks }}</p>
                            </div>
                            <div class="bg-purple-400 bg-opacity-30 p-3 rounded-full">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks In Progress -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm font-medium uppercase">In Progress</p>
                                <p class="text-4xl font-bold mt-2">{{ $tasksInProgress }}</p>
                            </div>
                            <div class="bg-orange-400 bg-opacity-30 p-3 rounded-full">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Task Status Breakdown -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Task Status Overview
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="border-l-4 border-gray-400 bg-gray-50 p-4 rounded">
                        <p class="text-gray-600 text-sm font-medium">To Do</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $tasksTodo }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $totalTasks > 0 ? round(($tasksTodo / $totalTasks) * 100) : 0 }}% of total</p>
                    </div>
                    <div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded">
                        <p class="text-blue-600 text-sm font-medium">In Progress</p>
                        <p class="text-3xl font-bold text-blue-900">{{ $tasksInProgress }}</p>
                        <p class="text-sm text-blue-500 mt-1">{{ $totalTasks > 0 ? round(($tasksInProgress / $totalTasks) * 100) : 0 }}% of total</p>
                    </div>
                    <div class="border-l-4 border-green-500 bg-green-50 p-4 rounded">
                        <p class="text-green-600 text-sm font-medium">Done</p>
                        <p class="text-3xl font-bold text-green-900">{{ $tasksDone }}</p>
                        <p class="text-sm text-green-500 mt-1">{{ $totalTasks > 0 ? round(($tasksDone / $totalTasks) * 100) : 0 }}% of total</p>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Recent Projects -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            Recent Projects
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($recentProjects->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentProjects as $project)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                        <div class="flex-1">
                                            <a href="{{ route('projects.show', $project) }}" class="font-medium text-gray-900 hover:text-indigo-600">
                                                {{ $project->name }}
                                            </a>
                                            <p class="text-sm text-gray-500">Owner: {{ $project->user->name }}</p>
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $project->created_at->diffForHumans() }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No projects yet</p>
                        @endif
                    </div>
                </div>

                <!-- User Activity -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            User Activity
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($userActivity->count() > 0)
                            <div class="space-y-3">
                                @foreach($userActivity->sortByDesc('projects_count')->take(5) as $user)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ ucfirst($user->role) }}</p>
                                            </div>
                                        </div>
                                        <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                                            {{ $user->projects_count }} {{ Str::plural('project', $user->projects_count) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No users yet</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Tasks -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Recent Tasks Activity
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentTasks as $task)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                            {{ Str::limit($task->title, 40) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <a href="{{ route('projects.show', $task->project) }}" class="hover:text-indigo-600">
                                            {{ $task->project->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $task->assignedUser->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $task->status === 'todo' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $task->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $task->status === 'done' ? 'bg-green-100 text-green-800' : '' }}">
                                            {{ str_replace('_', ' ', ucfirst($task->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $task->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">No tasks yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- All Projects Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">All Projects Overview</h3>
                    <a href="{{ route('projects.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All →</a>
                </div>
                <div class="p-6">
                    @if($projectsWithStats->count() > 0)
                        <div class="space-y-4">
                            @foreach($projectsWithStats as $item)
                                @php
                                    $project = $item['project'];
                                    $stats = $item['stats'];
                                    $total = array_sum($stats);
                                @endphp
                                <div class="border rounded-lg p-4 hover:shadow-md transition bg-gray-50">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-semibold text-lg">
                                                <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $project->name }}
                                                </a>
                                            </h4>
                                            <p class="text-sm text-gray-600 mt-1">Owner: <span class="font-medium">{{ $project->user->name }}</span> ({{ $project->user->email }})</p>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $project->created_at->format('M d, Y') }}</span>
                                    </div>

                                    <!-- Task Status Breakdown -->
                                    <div class="flex gap-4 mt-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-2xl font-bold text-gray-900">{{ $total }}</span>
                                            <span class="text-sm text-gray-600">Total</span>
                                        </div>
                                        <div class="flex-1 flex items-center gap-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                                                <span class="text-sm text-gray-600">{{ $stats['todo'] }} To Do</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                                <span class="text-sm text-gray-600">{{ $stats['in_progress'] }} Progress</span>
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
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500 mt-4">No projects in the system yet.</p>
                            <a href="{{ route('projects.create') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Create First Project
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
