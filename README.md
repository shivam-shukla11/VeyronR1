# VeyronR1 - Minimalist Login & Registration System

A clean, elegant Laravel application with user authentication system. Built for college submission.

## Features

- 🎨 Minimalist landing page with elegant design
- 🔐 User login (supports email OR mobile number)
- 📝 User registration with validation
- ✨ Success popup notifications
- 📱 Mobile-responsive design

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL database
- XAMPP/WAMP/LAMP or any PHP development environment

## Installation Steps

### Step 1: Download & Extract
Download the ZIP file and extract it to your web server directory:
- **XAMPP**: `C:\xampp\htdocs\veyronR1`
- **WAMP**: `C:\wamp64\www\veyronR1`
- **Linux**: `/var/www/html/veyronR1`

### Step 2: Install Dependencies
Open terminal/command prompt in the project folder and run:
```bash
composer install
```

### Step 3: Create Environment File
Copy the example environment file:
```bash
cp .env.example .env
```
Or on Windows:
```bash
copy .env.example .env
```

### Step 4: Generate Application Key
```bash
php artisan key:generate
```

### Step 5: Create Database
Open phpMyAdmin (http://localhost/phpmyadmin) and create a new database:
- Database name: `veyron_db` (or any name you prefer)
- Collation: `utf8mb4_unicode_ci`

### Step 6: Configure Database
Open the `.env` file and update database settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=veyron_db
DB_USERNAME=root
DB_PASSWORD=
```
> Note: Default XAMPP MySQL has no password. Adjust if yours is different.

### Step 7: Run Migrations
This creates all necessary database tables:
```bash
php artisan migrate
```

### Step 8: Start the Server
```bash
php artisan serve
```
Or with custom port:
```bash
php artisan serve --port=8080
```

### Step 9: Open in Browser
Visit: http://localhost:8000 (or your custom port)

## Database Tables Created

| Table | Purpose |
|-------|---------|
| users | Stores user accounts (first_name, last_name, email, mobile, password) |
| cache | Laravel cache storage |
| sessions | User session data |
| jobs | Background job queue |

## Login Credentials

After registration, you can login using:
- **Email** + Password
- **Mobile Number** + Password

## Project Structure

```
veyronR1/
├── app/
│   ├── Http/Controllers/AuthController.php  # Login & Register logic
│   └── Models/User.php                       # User model
├── resources/views/
│   ├── home.blade.php                        # Landing page
│   └── auth/
│       ├── login.blade.php                   # Login page
│       └── register.blade.php                # Registration page
├── routes/web.php                            # Application routes
└── database/migrations/                      # Database schema
```

## Troubleshooting

### Error: SQLSTATE[HY000] [1049] Unknown database
- Make sure you created the database in phpMyAdmin
- Check DB_DATABASE name in .env matches your database

### Error: Class not found
- Run `composer install` again
- Run `composer dump-autoload`

### Blank page or 500 error
- Check storage folder permissions
- Run `php artisan config:clear`
- Run `php artisan cache:clear`

## Author

**Shivam Shukla**  
College Submission Project

## License

This project is open-sourced software licensed under the MIT license.
