# 🌸 Aarunya Installation Guide

Quick setup guide to get Aarunya running on any system.

## 📋 Prerequisites

- **PHP 7.4+** (with PDO, MySQL extensions)
- **MySQL 5.7+** or **MariaDB**
- **Apache/Nginx** web server
- **XAMPP/WAMP** (recommended for local development)

## 🚀 Quick Installation

### Method 1: Automatic Setup (Recommended)

1. **Download/Clone** the project to your web server directory
2. **Start your web server** (XAMPP/WAMP)
3. **Run the setup script**: Navigate to `http://localhost/aarunya/setup.php`
4. **Follow the setup wizard** - it will create the database and default users automatically

### Method 2: Manual Setup

1. **Import Database**:
   ```sql
   CREATE DATABASE aarunya_db;
   ```
   Then import `database/aarunya_complete.sql`

2. **Configure Database**:
   Update `server/config/database.php` with your MySQL credentials:
   ```php
   private $host = 'localhost';
   private $dbname = 'aarunya_db';
   private $username = 'root';  // Your MySQL username
   private $password = '';      // Your MySQL password
   ```

3. **Set Permissions**:
   ```bash
   chmod 755 uploads/
   chmod 755 uploads/profile_photos/
   chmod 755 uploads/doctor_photos/
   ```

## 🔐 Default Login Credentials

### Admin Access
- **URL**: `http://localhost/aarunya/client/login.php`
- **Email**: `admin@aarunya.com`
- **Password**: `admin123`
- **Role**: Select "Admin" tab

### Test User Access
- **URL**: `http://localhost/aarunya/client/login.php`
- **Email**: `test@example.com`
- **Password**: `test123`
- **Role**: Select "Patient" tab

## 🔧 Troubleshooting

### Can't Login?

1. **Run Configuration Checker**: `http://localhost/aarunya/check_config.php`
2. **Run Setup Again**: `http://localhost/aarunya/setup.php`
3. **Check Database Connection**: Verify MySQL is running
4. **Clear Browser Cache**: Clear cookies and cache

### Common Issues

| Issue | Solution |
|-------|----------|
| Database connection failed | Check MySQL credentials in `server/config/database.php` |
| Login redirects to same page | Run `setup.php` to create default users |
| File upload errors | Set proper permissions on `uploads/` directory |
| Session errors | Check PHP session configuration |

### Database Connection Issues

If you're using different MySQL credentials:

1. Edit `server/config/database.php`
2. Update these values:
   ```php
   private $host = 'your_host';        // Usually 'localhost'
   private $dbname = 'your_database';  // Your database name
   private $username = 'your_user';    // Your MySQL username
   private $password = 'your_pass';    // Your MySQL password
   ```

## 📁 Project Structure

```
aarunya/
├── setup.php              # 🔧 Run this first!
├── check_config.php       # 🔍 Diagnostic tool
├── client/                # User interface
│   ├── index.html        # Landing page
│   ├── login.php         # Login page
│   └── dashboard.php     # User dashboard
├── admin/                 # Admin panel
│   └── pages/
│       └── dashboard.php # Admin dashboard
├── server/               # Backend
│   ├── config/          # Database config
│   └── handlers/        # Login handlers
└── database/            # SQL files
```

## 🎯 Quick Start Checklist

- [ ] Download/extract project files
- [ ] Start XAMPP/WAMP (Apache + MySQL)
- [ ] Visit `http://localhost/aarunya/setup.php`
- [ ] Follow setup wizard
- [ ] Test login with provided credentials
- [ ] Explore the application!

## 🆘 Need Help?

1. **Check Configuration**: Run `check_config.php`
2. **View Error Logs**: Check your web server error logs
3. **Reset Setup**: Delete database and run `setup.php` again
4. **Contact Support**: Create an issue on GitHub

## 🔄 Updating

To update the project:
1. Backup your database
2. Replace files (keep `server/config/database.php` if customized)
3. Run `setup.php` to apply any database updates

---

**Happy coding! 💖**