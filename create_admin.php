<?php

$commands = [
    "use App\\Models\\User;",
    "use Illuminate\\Support\\Facades\\Hash;",
    "User::where('email', 'admin@example.com')->delete();",
    "User::create(['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'role' => 'admin', 'email_verified_at' => now()]);",
    "echo 'Admin user created: admin@example.com / password';",
    "exit"
];

$tinkerInput = implode(PHP_EOL, $commands);
file_put_contents('tinker_commands.txt', $tinkerInput);
echo "Commands written to tinker_commands.txt\n";
echo "Run: php artisan tinker < tinker_commands.txt\n";
?>
