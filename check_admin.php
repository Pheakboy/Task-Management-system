<?php
require_once 'bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Checking Admin User ===\n";

// Find admin user
$admin = User::where('email', 'admin@example.com')->first();

if ($admin) {
    echo "Admin user found:\n";
    echo "ID: " . $admin->id . "\n";
    echo "Name: " . $admin->name . "\n";
    echo "Email: " . $admin->email . "\n";
    echo "Role: " . $admin->role . "\n";
    echo "Email Verified: " . ($admin->email_verified_at ? 'Yes' : 'No') . "\n";
    
    // Reset password
    $admin->password = Hash::make('password');
    $admin->save();
    
    echo "\n✅ Admin password reset to: password\n";
    echo "\nLogin at: http://127.0.0.1:8000/admin/login\n";
    echo "Email: admin@example.com\n";
    echo "Password: password\n";
} else {
    echo "❌ Admin user not found. Creating new admin user...\n";
    
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);
    
    echo "✅ Admin user created successfully!\n";
    echo "\nLogin at: http://127.0.0.1:8000/admin/login\n";
    echo "Email: admin@example.com\n";
    echo "Password: password\n";
}
?>
