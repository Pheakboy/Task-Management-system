<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the admin and regular user
        $admin = User::where('email', 'admin@example.com')->first();
        $user = User::where('email', 'user@example.com')->first();

        // Create projects for admin
        Project::create([
            'name' => 'Website Redesign',
            'description' => 'Complete redesign of the company website with modern UI/UX',
            'created_by' => $admin->id,
        ]);

        Project::create([
            'name' => 'Mobile App Development',
            'description' => 'Develop a mobile application for iOS and Android platforms',
            'created_by' => $admin->id,
        ]);

        // Create projects for regular user
        Project::create([
            'name' => 'Content Management System',
            'description' => 'Build a custom CMS for blog management',
            'created_by' => $user->id,
        ]);

        Project::create([
            'name' => 'E-commerce Platform',
            'description' => 'Online shopping platform with payment integration',
            'created_by' => $user->id,
        ]);

        Project::create([
            'name' => 'API Integration',
            'description' => 'Integrate third-party APIs for data synchronization',
            'created_by' => $user->id,
        ]);
    }
}
