# ESAE Benin Online Course Registration Portal

## Folder Structure

```text
regsys/
├── assets/
│   ├── css/style.css
│   └── js/main.js
├── config/
│   ├── app.php
│   ├── database.php
│   └── helpers.php
├── controllers/
│   ├── AdminController.php
│   ├── AuthController.php
│   ├── StudentController.php
│   └── course_action.php
├── database/
│   └── schema.sql
├── models/
│   ├── ActivityLog.php
│   ├── Admin.php
│   ├── Course.php
│   ├── Registration.php
│   └── Student.php
├── views/
│   ├── admin/
│   ├── auth/
│   ├── partials/
│   └── student/
├── admin_courses.php
├── admin_dashboard.php
├── admin_login.php
├── admin_registrations.php
├── admin_students.php
├── index.php
├── install.php
├── logout.php
├── student_courses.php
├── student_dashboard.php
├── student_login.php
├── student_register.php
└── student_registrations.php
```

## Database SQL

Import [database/schema.sql](/home/dell/Documents/regsys/database/schema.sql) into MySQL using phpMyAdmin or the MySQL CLI.

## XAMPP Setup Instructions

1. Copy the project folder into `htdocs`, for example `C:\xampp\htdocs\regsys`.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Create a database named `esae_course_portal` or simply import the SQL file, which will create it automatically.
4. Open `config/database.php` and update the database credentials if your MySQL settings are different from:
   - host: `localhost`
   - database: `esae_course_portal`
   - username: `root`
   - password: empty string
5. Visit `http://localhost/regsys/install.php` once to create the default admin account.
6. Open `http://localhost/regsys/` in your browser.

## Default Admin Account

- Username: `admin`
- Password: `admin123`

## Testing Guide

1. Register a new student account from `student_register.php`.
2. Log in as admin and add several courses.
3. Log in as the student and confirm:
   - course registration works with AJAX
   - duplicate registration is blocked
   - dropping courses works
   - search and pagination work on the course list
   - the credit unit limit is enforced
4. Open the admin dashboard and verify student, course, and registration counts.
5. Open the registrations and students pages to confirm data is displayed correctly.

## Security Notes

- Passwords are hashed with `password_hash()`.
- Session-based authentication protects student and admin routes.
- Prepared statements are used for all database access.
- CSRF tokens are used for POST forms and AJAX actions.
