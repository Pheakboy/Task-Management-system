# Task Management System

A comprehensive Laravel-based task management system with role-based access control, project management, and task tracking capabilities.

## Features

### 1. Authentication

-   User registration and login (Laravel Breeze)
-   Email verification
-   Password reset functionality
-   Session-based authentication

### 2. Role-Based Access Control

-   **Admin Role**: Full access to all projects, tasks, and users
-   **User Role**: Access only to own projects and tasks
-   Role-based middleware and policies

### 3. Project Management

-   Create, read, update, and delete projects
-   Each project has:
    -   Name (required, max 255 characters)
    -   Description (optional, text)
    -   Owner (created_by user)
    -   Timestamps
-   Admin can manage all projects
-   Users can only manage their own projects

### 4. Task Management

-   Create, read, update, and delete tasks
-   Each task has:
    -   Title (required, max 255 characters)
    -   Description (optional, text)
    -   Project assignment (belongs to a project)
    -   User assignment (assigned to a user)
    -   Status (enum: todo, in_progress, done)
    -   Due date (optional)
    -   Timestamps
-   Users can assign tasks to themselves or other users
-   Status workflow: todo → in_progress → done
-   Admin can manage all tasks across all projects

### 5. Dashboard

-   Displays projects with task statistics
-   Visual progress bars showing task completion
-   Task breakdown by status (todo, in_progress, done)
-   Admin sees all projects; users see only their own

### 6. Filtering & Search

-   Filter tasks by:
    -   Project
    -   Status (todo, in_progress, done)
    -   Assigned user
-   Search functionality:
    -   Search by task title
    -   Search by project name
-   All filters can be combined for precise results

## Technology Stack

-   **Framework**: Laravel 12.0
-   **PHP Version**: 8.2+
-   **Authentication**: Laravel Breeze (Blade stack)
-   **Database**: MySQL
-   **Frontend**: Blade Templates + Tailwind CSS
-   **Server**: XAMPP (Apache + MySQL)

## Requirements

-   PHP 8.2 or higher
-   Composer
-   MySQL Database
-   Node.js and NPM (for asset compilation)
-   XAMPP or similar local development environment

## Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/Pheakboy/Task-Management-system.git
cd Task-Management-system
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Create Database

Create a new MySQL database named `task_management`:

```sql
CREATE DATABASE task_management;
```

Or use phpMyAdmin (XAMPP):

1. Open http://localhost/phpmyadmin
2. Click "New" to create a new database
3. Name it `task_management`
4. Select `utf8mb4_unicode_ci` collation
5. Click "Create"

### 6. Run Migrations

```bash
php artisan migrate
```

This will create all necessary tables:

-   users (with role column)
-   projects
-   tasks
-   password_reset_tokens
-   sessions
-   cache
-   jobs

### 7. Run Seeders

```bash
php artisan db:seed
```

This will create:

-   **Admin User**:
    -   Email: `admin@example.com`
    -   Password: `password`
    -   Role: Admin
-   **Regular User**:

    -   Email: `user@example.com`
    -   Password: `password`
    -   Role: User

-   **Sample Projects**: 5 projects (2 for admin, 3 for user)
-   **Sample Tasks**: 3-5 tasks per project with various statuses

### 8. Compile Assets

```bash
# For development
npm run dev

# For production
npm run build
```

### 9. Start the Application

```bash
# Make sure XAMPP Apache and MySQL are running
# Then start the Laravel development server
php artisan serve
```

The application will be available at: http://127.0.0.1:8000

## Default Login Credentials

### Admin Account

-   **Email**: `admin@example.com`
-   **Password**: `password`
-   **Capabilities**: Full access to all projects, tasks, and users

### Regular User Account

-   **Email**: `user@example.com`
-   **Password**: `password`
-   **Capabilities**: Access only to own projects and tasks

## Database Structure

### Users Table

-   id (primary key)
-   name
-   email (unique)
-   password
-   role (enum: admin, user) - default: user
-   email_verified_at
-   remember_token
-   timestamps

### Projects Table

-   id (primary key)
-   name (string, 255)
-   description (text, nullable)
-   created_by (foreign key → users.id, cascade delete)
-   timestamps

### Tasks Table

-   id (primary key)
-   project_id (foreign key → projects.id, cascade delete)
-   title (string, 255)
-   description (text, nullable)
-   assigned_to (foreign key → users.id, cascade delete)
-   status (enum: todo, in_progress, done) - default: todo
-   due_date (date, nullable)
-   timestamps
-   Indexes: project_id, assigned_to, status

## Authorization Policies

### ProjectPolicy

-   viewAny: All authenticated users
-   view: Admin or project owner
-   create: All authenticated users
-   update: Admin or project owner
-   delete: Admin or project owner

### TaskPolicy

-   viewAny: All authenticated users
-   view: Admin or project owner (through task.project.created_by)
-   create: All authenticated users
-   update: Admin or project owner
-   delete: Admin or project owner

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php (Dashboard with filtering)
│   │   ├── ProjectController.php (Project CRUD)
│   │   └── TaskController.php (Task CRUD + status updates)
│   └── Middleware/
│       └── AdminMiddleware.php (Role-based access)
├── Models/
│   ├── User.php (with isAdmin/isUser methods)
│   ├── Project.php (with taskCountsByStatus method)
│   └── Task.php
├── Policies/
│   ├── ProjectPolicy.php
│   └── TaskPolicy.php
└── Providers/
    └── AuthServiceProvider.php

database/
├── factories/
│   ├── ProjectFactory.php
│   ├── TaskFactory.php
│   └── UserFactory.php
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 2025_10_17_153527_add_role_to_users_table.php
│   ├── 2025_10_19_094202_create_projects_table.php
│   └── 2025_10_19_100608_create_tasks_table.php
└── seeders/
    ├── AdminUserSeeder.php
    ├── ProjectSeeder.php
    ├── TaskSeeder.php
    └── DatabaseSeeder.php

resources/
└── views/
    ├── dashboard.blade.php (with filters)
    ├── projects/ (index, create, edit, show)
    ├── tasks/ (index, create, edit, show)
    └── layouts/
        └── navigation.blade.php

routes/
└── web.php
```

## Usage Guide

### As Admin

1. Login with `admin@example.com` / `password`
2. Dashboard shows all projects from all users
3. Create/Edit/Delete any project or task
4. Assign tasks to any user
5. View complete system overview

### As Regular User

1. Login with `user@example.com` / `password`
2. Dashboard shows only your projects
3. Create/Edit/Delete your own projects
4. Create/Edit/Delete tasks in your projects
5. Assign tasks to any user (including yourself)
6. Cannot access other users' projects

### Using Filters (Dashboard)

1. Go to Dashboard
2. Use filter panel at the top:
    - **Search Task**: Enter task title keywords
    - **Search Project**: Enter project name keywords
    - **Task Status**: Select todo/in_progress/done
    - **Assigned To**: Select a user
3. Click "Apply Filters" to see filtered results
4. Click "Clear Filters" to reset

### Task Management

1. Go to Projects → Click a project
2. View task list with statistics
3. Click "+ Add Task" to create new task
4. Fill in task details:
    - Title (required)
    - Description (optional)
    - Assign to user
    - Set status
    - Set due date (optional)
5. Click "Edit" to modify task
6. Click "Delete" to remove task
7. Use quick status buttons on task show page

## Testing the Application

### Manual Testing Checklist

1. **Authentication**

    - [ ] Register new user
    - [ ] Login as admin
    - [ ] Login as user
    - [ ] Logout

2. **Project Management**

    - [ ] Create new project
    - [ ] Edit project
    - [ ] View project details
    - [ ] Delete project
    - [ ] Verify authorization (users can't edit others' projects)

3. **Task Management**

    - [ ] Create task in project
    - [ ] Assign task to user
    - [ ] Change task status
    - [ ] Edit task details
    - [ ] Delete task
    - [ ] Set due date

4. **Dashboard & Filters**

    - [ ] View project statistics
    - [ ] Filter by status
    - [ ] Filter by assigned user
    - [ ] Search by task title
    - [ ] Search by project name
    - [ ] Clear filters

5. **Role-Based Access**
    - [ ] Admin can see all projects
    - [ ] User can see only own projects
    - [ ] Admin can manage any task
    - [ ] User can manage only own project tasks

## Troubleshooting

### Issue: "Class 'AdminMiddleware' not found"

**Solution**: Make sure the middleware is registered in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
})
```

### Issue: "Policy not found"

**Solution**: Verify `AuthServiceProvider` is registered in `bootstrap/providers.php`

### Issue: Database connection error

**Solution**:

1. Ensure MySQL is running in XAMPP
2. Check database credentials in `.env`
3. Verify database exists

### Issue: Assets not loading

**Solution**: Run `npm run build` and clear browser cache

## Development Best Practices

This project follows Laravel best practices:

-   ✅ **MVC Architecture**: Clean separation of concerns
-   ✅ **Eloquent ORM**: For database operations
-   ✅ **Policy-Based Authorization**: Fine-grained access control
-   ✅ **Resource Controllers**: RESTful routing
-   ✅ **Form Requests**: Input validation
-   ✅ **Factories & Seeders**: Test data generation
-   ✅ **Blade Templates**: Reusable view components
-   ✅ **Middleware**: Request filtering and authentication

## Future Enhancements

Potential features to add:

-   Task comments and attachments
-   Email notifications for task assignments
-   Task priority levels
-   Project categories/tags
-   Activity logs and audit trail
-   Export projects/tasks to PDF
-   Task templates
-   Team collaboration features
-   Kanban board view
-   Calendar view for tasks

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

-   **Framework**: [Laravel](https://laravel.com)
-   **Authentication**: [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)
-   **Styling**: [Tailwind CSS](https://tailwindcss.com)

## Support

For issues or questions:

-   Open an issue on GitHub
-   Contact: pheakboy@example.com

---

**Developed with ❤️ using Laravel**

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
