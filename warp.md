# Warp - Laravel Example Application

## Project Overview

This is a Laravel 12.x application configured with modern development tools and practices. The project serves as a foundation for web application development using the Laravel framework.

## Technology Stack

### Backend
- **PHP**: ^8.2
- **Laravel Framework**: ^12.0
- **Laravel Tinker**: ^2.10.1 (Interactive shell)

### Frontend
- **Vite**: ^7.0.7 (Build tool)
- **TailwindCSS**: ^4.0.0 (CSS framework)
- **Axios**: ^1.11.0 (HTTP client)

### Development Tools
- **Testing**: Pest PHP ^3.8 (Testing framework)
- **Code Quality**: Laravel Pint ^1.24 (Code formatter)
- **Local Development**: Laravel Sail ^1.41 (Docker environment)
- **Logging**: Laravel Pail ^1.2.2 (Log viewer)

## Project Structure

```
example-app/
├── app/                    # Application logic
├── bootstrap/             # Framework bootstrap files
├── config/                # Configuration files
├── database/              # Migrations, factories, seeders
├── public/                # Web server document root
├── resources/             # Views, assets, lang files
├── routes/                # Route definitions
├── storage/               # Generated files, logs, cache
├── tests/                 # Test files
├── vendor/                # Composer dependencies
└── node_modules/          # NPM dependencies
```

## Environment Setup

### Prerequisites
- PHP 8.2 or higher
- Composer (PHP dependency manager)
- Node.js and NPM
- MySQL/PostgreSQL or SQLite database

### Installation Commands
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate

# Build assets
npm run build
```

### Quick Setup (Automated)
```bash
composer run setup
```

## Development Commands

### Start Development Server
```bash
# Full development stack (server + queue + vite)
composer run dev

# Or individual commands:
php artisan serve          # Laravel server
npm run dev                # Vite development server
php artisan queue:work     # Queue worker
```

### Testing
```bash
# Run all tests
composer run test

# Or directly with Pest
php artisan test
```

### Code Quality
```bash
# Format code with Pint
vendor/bin/pint

# Or via composer script if available
composer run format
```

## Key Features

### Database
- SQLite database (default for development)
- Eloquent ORM for database interactions
- Migration system for database versioning

### Frontend Assets
- Vite for fast asset compilation
- TailwindCSS for utility-first styling
- Hot module replacement in development

### Testing
- Pest PHP for elegant testing syntax
- Laravel testing utilities
- Database factories and seeders

### Development Experience
- Concurrently runs multiple dev processes
- Queue processing for background jobs
- Laravel Tinker for interactive debugging

## Environment Configuration

### Database
- Default: SQLite (`database/database.sqlite`)
- Configurable via `.env` file for MySQL/PostgreSQL

### Debug Mode
- Enabled in development (`.env`: `APP_DEBUG=true`)
- Detailed error reporting and logging

### Asset Compilation
- Development: `npm run dev` (watch mode)
- Production: `npm run build` (optimized)

## Common Tasks

### Creating New Components
```bash
# Controller
php artisan make:controller ExampleController

# Model with migration
php artisan make:model Example -m

# Migration
php artisan make:migration create_examples_table

# Test
php artisan make:test ExampleTest
```

### Database Operations
```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Seed database
php artisan db:seed
```

## Authentication System

### Laravel Breeze Implementation
The application includes a complete authentication system built with Laravel Breeze:

- **User Registration**: New users can register with name, email, and password
- **User Login/Logout**: Secure authentication with remember me functionality
- **Password Reset**: Email-based password reset functionality
- **Email Verification**: Optional email verification for new accounts

### Role-Based Access Control
Users are assigned one of two roles:
- **User**: Default role with access to user dashboard and profile management
- **Admin**: Elevated privileges with access to administrative functions

### Test Accounts
The following test accounts are available:
```
Admin Account:
Email: admin@example.com
Password: password
Role: admin

User Account:
Email: user@example.com
Password: password
Role: user
```

### Routes
- `/login` - Login page
- `/register` - Registration page
- `/dashboard` - Role-based dashboard (auto-redirects based on user role)
- `/admin/dashboard` - Admin-only dashboard (requires admin middleware)
- `/profile` - User profile management

### Middleware
- `auth` - Requires user authentication
- `admin` - Requires admin role (custom middleware)
- `verified` - Requires email verification

## Requirements Summary

This Laravel application is designed for modern web development with:
- **Backend API/Web development** using Laravel 12
- **Authentication System** with Laravel Breeze and role-based access control
- **Modern frontend tooling** with Vite and TailwindCSS
- **Testing-first approach** with Pest PHP
- **Developer experience** optimized with hot reloading and concurrent processes
- **Production-ready** deployment capabilities
- **Scalable architecture** following Laravel conventions

The project structure supports both traditional server-rendered applications and modern SPA/API development patterns.
