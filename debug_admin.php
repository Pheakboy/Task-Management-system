#!/usr/bin/env php
<?php

// Bootstrap Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== DEBUGGING ADMIN LOGIN ISSUE ===\n\n";

// Find admin user by role
$admins = User::where('role', 'admin')->get();
echo "Users with role 'admin': " . $admins->count() . "\n";

foreach ($admins as $admin) {
    echo "\nAdmin User Details:\n";
    echo "ID: " . $admin->id . "\n";
    echo "Name: " . $admin->name . "\n";
    echo "Email: " . $admin->email . "\n";
    echo "Role: '" . $admin->role . "'\n";
    echo "Email Verified: " . ($admin->email_verified_at ? 'Yes' : 'No') . "\n";
    echo "Created: " . $admin->created_at . "\n";
}

// Specifically check for admin@example.com
echo "\n" . str_repeat("=", 50) . "\n";
$specificAdmin = User::where('email', 'admin@example.com')->first();

if ($specificAdmin) {
    echo "✅ Found admin@example.com\n";
    echo "Current role: '" . $specificAdmin->role . "'\n";
    echo "Role check (isAdmin): " . ($specificAdmin->isAdmin() ? 'TRUE' : 'FALSE') . "\n";
    
    // Reset password to be absolutely sure
    $specificAdmin->password = Hash::make('password');
    $specificAdmin->email_verified_at = now();
    $specificAdmin->save();
    
    echo "\n✅ Password reset to 'password'\n";
    echo "✅ Email verified\n";
    
    // Test password
    if (Hash::check('password', $specificAdmin->password)) {
        echo "✅ Password verification works\n";
    } else {
        echo "❌ Password verification failed\n";
    }
    
} else {
    echo "❌ admin@example.com not found\n";
    echo "Creating new admin user...\n";
    
    $newAdmin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);
    
    echo "✅ New admin user created\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🔑 LOGIN CREDENTIALS:\n";
echo "URL: http://127.0.0.1:8000/admin/login\n";
echo "Email: admin@example.com\n";
echo "Password: password\n";
echo str_repeat("=", 50) . "\n";
?>
