# Quick Setup Guide

## 🚀 Quick Start (5 Steps)

### Step 1: Install Dependencies

```bash
composer install
npm install
```

### Step 2: Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3: Create Database

Create a MySQL database named `task_management` using phpMyAdmin or MySQL command:

```sql
CREATE DATABASE task_management;
```

### Step 4: Setup Database

```bash
php artisan migrate:fresh --seed
```

### Step 5: Start Application

```bash
# Terminal 1: Compile assets
npm run dev

# Terminal 2: Start server
php artisan serve
```

Visit: http://127.0.0.1:8000

---

## 🔑 Login Credentials

### Admin

-   **Email**: admin@example.com
-   **Password**: password
-   **Access**: All projects and tasks

### User

-   **Email**: user@example.com
-   **Password**: password
-   **Access**: Own projects only

---

## 📋 What Gets Created

After running seeders, you will have:

-   ✅ 2 users (1 admin, 1 regular user)
-   ✅ 5 sample projects
    -   2 projects owned by admin
    -   3 projects owned by regular user
-   ✅ 15-25 sample tasks
    -   3-5 tasks per project
    -   Various statuses (todo, in_progress, done)
    -   Random due dates
    -   Assigned to different users

---

## 🛠️ Common Commands

### Reset Database (Fresh Start)

```bash
php artisan migrate:fresh --seed
```

### Run Only Seeders

```bash
php artisan db:seed
```

### Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Check Routes

```bash
php artisan route:list
```

---

## ✅ Verify Installation

After setup, you should be able to:

1. ✅ Login as admin (admin@example.com)
2. ✅ See 5 projects on dashboard
3. ✅ See task statistics for each project
4. ✅ Filter tasks by status/user
5. ✅ Create new projects and tasks
6. ✅ Login as user (user@example.com)
7. ✅ See only 3 projects (user's own projects)
8. ✅ Create tasks in own projects

---

## 🐛 Troubleshooting

### Problem: "SQLSTATE[HY000] [1049] Unknown database"

**Solution**: Create the database first:

```sql
CREATE DATABASE task_management;
```

### Problem: "Class 'AdminMiddleware' not found"

**Solution**: Clear config cache:

```bash
php artisan config:clear
```

### Problem: Assets not loading

**Solution**: Run build:

```bash
npm run build
```

### Problem: "Access denied for user 'root'@'localhost'"

**Solution**: Check MySQL credentials in `.env` file

---

## 📁 Important Files

-   `database/migrations/` - Database structure
-   `database/seeders/` - Sample data generators
-   `app/Models/` - User, Project, Task models
-   `app/Policies/` - Authorization rules
-   `routes/web.php` - Application routes
-   `README.md` - Complete documentation

---

## 🎯 Next Steps

1. Test the application with provided credentials
2. Create your own projects and tasks
3. Test filtering and search features
4. Explore admin vs user permissions
5. Customize as needed for your requirements

---

**Need Help?** Check the full README.md for detailed documentation.
