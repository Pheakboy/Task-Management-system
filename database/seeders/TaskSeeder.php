<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $user = User::where('email', 'user@example.com')->first();
        $projects = Project::all();

        foreach ($projects as $project) {
            // Create 3-5 tasks per project
            $taskCount = rand(3, 5);
            
            for ($i = 0; $i < $taskCount; $i++) {
                Task::create([
                    'project_id' => $project->id,
                    'title' => $this->getTaskTitle($i),
                    'description' => $this->getTaskDescription($i),
                    'assigned_to' => rand(0, 1) ? $admin->id : $user->id,
                    'status' => ['todo', 'in_progress', 'done'][rand(0, 2)],
                    'due_date' => now()->addDays(rand(1, 30)),
                ]);
            }
        }
    }

    private function getTaskTitle($index): string
    {
        $titles = [
            'Setup project structure',
            'Design database schema',
            'Implement user authentication',
            'Create API endpoints',
            'Write documentation',
            'Perform testing',
            'Deploy to production',
            'Fix bugs and issues',
            'Add new features',
            'Optimize performance',
        ];

        return $titles[$index % count($titles)];
    }

    private function getTaskDescription($index): string
    {
        $descriptions = [
            'Initialize the project with necessary dependencies and folder structure',
            'Design and plan the database tables and relationships',
            'Implement login, registration, and password reset functionality',
            'Create RESTful API endpoints for CRUD operations',
            'Document the code, API, and setup instructions',
            'Write unit and integration tests for all features',
            'Deploy the application to the production server',
            'Identify and fix any bugs reported by users',
            'Add requested features based on user feedback',
            'Improve application performance and load times',
        ];

        return $descriptions[$index % count($descriptions)];
    }
}
