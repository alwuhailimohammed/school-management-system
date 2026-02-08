# School Management System

A comprehensive web-based school management system built with HTML, CSS, PHP, and MySQL.

## Features

- **User Authentication**: Secure login/logout system with password hashing
- **Dashboard**: Overview with statistics of students, teachers, courses, and classes
- **Student Management**: Add, view, and delete student records
- **Teacher Management**: Add, view, and delete teacher records
- **Course Management**: Manage courses/subjects with codes and credits
- **Class Management**: Organize classes with sections and assigned teachers
- **Attendance System**: Record and track student attendance
- **Grade Management**: Record and manage student grades/marks with automatic grade calculation
- **Responsive Design**: Modern UI with gradient backgrounds and clean layout

## Technologies Used

- **Frontend**: HTML5, CSS3
- **Backend**: PHP
- **Database**: MySQL
- **Authentication**: PHP Sessions with password hashing

## Installation

### Prerequisites

- PHP 7.0 or higher
- MySQL 5.6 or higher
- Apache/Nginx web server
- phpMyAdmin (optional, for database management)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/alwuhailimohammed/school-management-system.git
   cd school-management-system
   ```

2. **Configure Database**
   - Create a MySQL database named `school_management`
   - Import the database schema:
     ```bash
     mysql -u root -p school_management < database/school_db.sql
     ```
   - Or manually execute the SQL file through phpMyAdmin

3. **Configure Database Connection**
   - Edit `config/database.php` and update the database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     define('DB_NAME', 'school_management');
     ```

4. **Set Permissions** (Linux/Mac)
   ```bash
   chmod -R 755 /path/to/school-management-system
   ```

5. **Start the Application**
   - Place the project in your web server's document root (e.g., `htdocs` for XAMPP, `www` for WAMP)
   - Access the application via: `http://localhost/school-management-system`

## Default Login Credentials

- **Username**: admin
- **Password**: admin123

**Important**: Change the default password after first login!

## Project Structure

```
school-management-system/
├── config/
│   └── database.php          # Database configuration
├── css/
│   └── style.css             # Main stylesheet
├── database/
│   └── school_db.sql         # Database schema
├── includes/
│   └── auth.php              # Authentication helper
├── index.php                 # Login page
├── login.php                 # Login handler
├── logout.php                # Logout handler
├── dashboard.php             # Main dashboard
├── students.php              # Student listing
├── add_student.php           # Add student form
├── teachers.php              # Teacher listing
├── add_teacher.php           # Add teacher form
├── courses.php               # Course management
├── classes.php               # Class management
├── attendance.php            # Attendance tracking
└── grades.php                # Grade management
```

## Database Schema

### Tables

1. **users** - User authentication (admin, teacher, student)
2. **students** - Student information and details
3. **teachers** - Teacher information and details
4. **courses** - Course/subject information
5. **classes** - Class organization with sections
6. **attendance** - Student attendance records
7. **grades** - Student grades and marks

## Usage

### Admin Features

1. **Login**: Use admin credentials to access the system
2. **Dashboard**: View statistics and quick access to all modules
3. **Manage Students**: Add new students with complete information
4. **Manage Teachers**: Add new teachers with employment details
5. **Manage Courses**: Create and manage courses/subjects
6. **Manage Classes**: Organize classes with sections and assign teachers
7. **Record Attendance**: Mark student attendance daily
8. **Record Grades**: Enter student marks with automatic grade calculation

### Grade Calculation

The system automatically calculates letter grades based on percentage:
- A+ : 90-100%
- A  : 80-89%
- B  : 70-79%
- C  : 60-69%
- D  : 50-59%
- F  : Below 50%

## Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection prevention using prepared statements
- Session-based authentication
- XSS protection with `htmlspecialchars()`
- Admin-only access control for management features

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/YourFeature`)
3. Commit your changes (`git commit -m 'Add YourFeature'`)
4. Push to the branch (`git push origin feature/YourFeature`)
5. Open a Pull Request

## License

This project is open source and available under the [MIT License](LICENSE).

## Support

For issues, questions, or contributions, please open an issue on GitHub.

## Author

Mohammed Alwuhaili

## Acknowledgments

- Built for Iraqi schools
- Designed with simplicity and usability in mind
- Modern responsive design for all devices
