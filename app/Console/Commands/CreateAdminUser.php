<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin and test users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check if admin user exists
        $adminExists = User::where('email', 'admin@example.com')->exists();
        $userExists = User::where('email', 'user@example.com')->exists();

        if (!$adminExists) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'email_verified_at' => now(),
            ]);
            $this->info('Admin user created: admin@example.com');
        } else {
            $this->info('Admin user already exists');
        }

        if (!$userExists) {
            User::create([
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role' => User::ROLE_USER,
                'email_verified_at' => now(),
            ]);
            $this->info('Regular user created: user@example.com');
        } else {
            $this->info('Regular user already exists');
        }

        $this->info('\nCredentials:');
        $this->info('Admin: admin@example.com / password');
        $this->info('User: user@example.com / password');
    }
}
