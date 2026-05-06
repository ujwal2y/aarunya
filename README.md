# Aarunya - Maternal Healthcare System

A complete maternal healthcare web application built with HTML5, CSS3, JavaScript, PHP, and MySQL.

## Features

### User Portal
- User registration and login
- Health dashboard
- Doctor consultation booking
- Profile management
- Maternal health tracking

### Admin Panel
- Dashboard with statistics
- User management
- Doctor management
- Appointment management
- Emergency request handling
- Reports and analytics

## Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **UI Theme**: Maternal care theme with lavender accent (#C4A7FF)

## Quick Start

1. **Import Database**
   ```bash
   mysql -u root -p < database/aarunya_complete.sql
   ```

2. **Configure Database**
   - Update `includes/db.php` with your database credentials
   - Update `admin/includes/db.php` with your database credentials

3. **Access Application**
   - User Portal: `http://localhost/Aarunya/`
   - Admin Panel: `http://localhost/Aarunya/admin/pages/dashboard.php`

## Default Credentials

### Admin Login
- Email: `admin@aarunya.com`
- Password: `admin123`

### Test User Login
- Email: `test@example.com`
- Password: ` test123 `

## Project Structure

```
Aarunya/
├── admin/                  # Admin panel
│   ├── assets/            # CSS, JS files
│   ├── includes/          # Auth, DB, header, footer
│   └── pages/             # Admin pages
├── database/              # SQL schema
├── includes/              # Shared includes
├── frontend/              # User portal HTML
├── index.html             # Landing page
├── login.php              # Unified login
└── register.php           # User registration
```

## Requirements

- PHP 7.4+
- MySQL 5.7+
- Apache/Nginx web server
- XAMPP/WAMP (recommended for local development)

## 🛠 **Quick Installation**

### **Automatic Setup (Recommended)**

1. **Download the project** to your web server directory
2. **Start your web server** (XAMPP/WAMP/MAMP)
3. **Run the setup script**: Navigate to `http://localhost/aarunya/setup.php`
4. **Follow the setup wizard** - it will automatically:
   - Create the database (`aarunya_db`)
   - Set up all required tables
   - Create default admin and user accounts
   - Add sample doctors and data

### **Manual Setup**

If you prefer manual setup or need custom configuration:

1. **Import Database**
   ```bash
   mysql -u root -p < database/aarunya_complete.sql
   ```

2. **Configure Database**
   Update `server/config/database.php` with your MySQL credentials:
   ```php
   private $host = 'localhost';
   private $dbname = 'aarunya_db';
   private $username = 'root';      // Your MySQL username
   private $password = '';          // Your MySQL password
   ```

3. **Set Permissions**
   ```bash
   chmod 755 uploads/
   chmod 755 uploads/profile_photos/
   chmod 755 uploads/doctor_photos/
   ```

### **🔐 Default Login Credentials**

After setup, use these credentials to access the system:

**Admin Access:**
- URL: `http://localhost/aarunya/client/login.php`
- Email: `admin@aarunya.com`
- Password: `admin123`
- Role: Select "Admin" tab

**Test User Access:**
- URL: `http://localhost/aarunya/client/login.php`
- Email: `test@example.com`
- Password: `test123`
- Role: Select "Patient" tab

### **🔧 Troubleshooting**

If you encounter login issues:

1. **Run diagnostics**: Visit `http://localhost/aarunya/check_config.php`
2. **Reset setup**: Visit `http://localhost/aarunya/setup.php`
3. **Check database**: Ensure MySQL is running and accessible
4. **Verify files**: Ensure all project files are properly uploaded
5. **Clear cache**: Clear browser cookies and cache

**Common Issues:**
- **Database connection failed**: Check MySQL credentials in `server/config/database.php`
- **Login redirects to same page**: Run `setup.php` to create default users
- **File upload errors**: Set proper permissions on `uploads/` directory
- **Session errors**: Check PHP session configuration

## License

MIT License
