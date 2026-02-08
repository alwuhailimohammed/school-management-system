# Installation Guide

## Quick Setup Guide for School Management System

### Step 1: Install Prerequisites

#### For Windows (XAMPP)
1. Download and install [XAMPP](https://www.apachefriends.org/)
2. Start Apache and MySQL from XAMPP Control Panel

#### For Mac (MAMP)
1. Download and install [MAMP](https://www.mamp.info/)
2. Start servers from MAMP

#### For Linux
```bash
sudo apt update
sudo apt install apache2 php mysql-server php-mysql
sudo systemctl start apache2
sudo systemctl start mysql
```

### Step 2: Setup Database

1. Open phpMyAdmin (usually at `http://localhost/phpmyadmin`)
2. Click "New" to create a new database
3. Name it `school_management`
4. Click "Import" tab
5. Choose the file `database/school_db.sql`
6. Click "Go" to import

**OR** use command line:
```bash
mysql -u root -p
CREATE DATABASE school_management;
exit;
mysql -u root -p school_management < database/school_db.sql
```

### Step 3: Configure Database Connection

1. Open `config/database.php`
2. Update the following values if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');        // Your MySQL username
   define('DB_PASS', '');            // Your MySQL password
   define('DB_NAME', 'school_management');
   ```

### Step 4: Deploy Application

#### XAMPP (Windows/Mac)
- Copy the entire project folder to `C:\xampp\htdocs\school-management-system`
- Access via: `http://localhost/school-management-system`

#### MAMP (Mac)
- Copy the project to `/Applications/MAMP/htdocs/school-management-system`
- Access via: `http://localhost:8888/school-management-system`

#### Linux
- Copy to `/var/www/html/school-management-system`
- Set permissions:
  ```bash
  sudo chown -R www-data:www-data /var/www/html/school-management-system
  sudo chmod -R 755 /var/www/html/school-management-system
  ```
- Access via: `http://localhost/school-management-system`

### Step 5: First Login

1. Open your web browser
2. Go to your application URL
3. Login with default credentials:
   - **Username**: admin
   - **Password**: admin123
4. **Important**: Change the default password immediately!

### Step 6: Start Using the System

After login, you can:
- Add students and teachers
- Create courses and classes
- Record attendance
- Manage grades

## Troubleshooting

### Database Connection Error
- Check if MySQL is running
- Verify database credentials in `config/database.php`
- Ensure database `school_management` exists

### Page Not Found
- Check if Apache is running
- Verify the project is in the correct directory
- Check the URL is correct

### Permission Denied (Linux)
```bash
sudo chown -R www-data:www-data /var/www/html/school-management-system
sudo chmod -R 755 /var/www/html/school-management-system
```

### Cannot Import Database
- Check file size limits in php.ini
- Ensure MySQL is running
- Verify the SQL file path is correct

## Testing

To verify the installation:
1. Login successfully
2. Dashboard should show statistics (all zeros initially)
3. Try adding a test student
4. Check if the student appears in the students list

## Security Recommendations

1. Change default admin password immediately
2. Use strong passwords for all users
3. Update database credentials to use a non-root user
4. Enable HTTPS in production
5. Regular database backups
6. Keep PHP and MySQL updated

## Support

For issues or questions:
- Check the README.md file
- Review the troubleshooting section
- Open an issue on GitHub

## Next Steps

1. Customize the system settings
2. Add your school's data
3. Create user accounts for teachers and students
4. Configure class schedules
5. Start recording attendance and grades

Enjoy using the School Management System!
