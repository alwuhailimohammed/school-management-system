# School Management System - Iraq

A comprehensive command-line based school management system for managing students, teachers, classes, and subjects.

## Features

- **Student Management**: Add, view, update, and delete student records
- **Teacher Management**: Manage teacher information and assignments
- **Class Management**: Create and manage classes, assign teachers, and enroll students
- **Subject Management**: Organize and track different subjects
- **Reports**: Generate various reports including summaries and filtered views
- **Data Persistence**: All data is saved in JSON format for easy backup and portability

## Requirements

- Python 3.6 or higher
- No external dependencies required (uses only Python standard library)

## Installation

1. Clone this repository:
```bash
git clone https://github.com/alwuhailimohammed/school-management-system.git
cd school-management-system
```

2. The system is ready to use! No additional installation needed.

## Usage

### Starting the System

Run the main application:
```bash
python school_management.py
```

### Creating Demo Data

To populate the system with sample data:
```bash
python create_demo_data.py
```

This will create:
- 6 sample students across grades 10-12
- 4 teachers for different subjects
- 4 classes
- 4 subjects
- Sample enrollments and assignments

### Main Menu Options

1. **Student Management**
   - Add new students
   - View all students
   - View individual student details
   - Update student information
   - Delete students

2. **Teacher Management**
   - Add new teachers
   - View all teachers
   - View individual teacher details
   - Update teacher information
   - Delete teachers

3. **Class Management**
   - Add new classes
   - View all classes
   - View class details (students, teacher, etc.)
   - Assign teachers to classes
   - Enroll students in classes
   - Delete classes

4. **Subject Management**
   - Add new subjects
   - View all subjects
   - View subject details
   - Delete subjects

5. **Reports**
   - Summary report (total counts)
   - Students grouped by grade
   - Teachers grouped by subject
   - Classes grouped by grade

## Data Structure

The system uses a simple JSON file (`school_data.json`) to store all data. The file is automatically created and updated as you use the system.

### Data Models

- **Student**: ID, Name, Grade, Age, Parent Contact, Enrolled Classes
- **Teacher**: ID, Name, Subject, Contact, Assigned Classes
- **Class**: ID, Name, Grade, Room Number, Students, Teacher
- **Subject**: ID, Name, Description, Classes

## Examples

### Adding a Student

```
Student ID: S007
Name: Ali Mohammed
Grade: 10
Age: 15
Parent Contact: 0771-234-5678
```

### Enrolling a Student in a Class

1. Navigate to Class Management > Enroll Student in Class
2. Enter the Class ID (e.g., C001)
3. Enter the Student ID (e.g., S007)
4. The system will confirm enrollment

### Viewing Reports

Navigate to Reports menu and select:
- Summary Report: Shows total counts of students, teachers, classes, and subjects
- Students by Grade: Lists all students organized by their grade level
- Teachers by Subject: Lists all teachers organized by their subject area
- Classes by Grade: Lists all classes organized by grade level

## File Structure

```
school-management-system/
├── README.md                 # This file
├── models.py                 # Data models (Student, Teacher, Class, Subject)
├── database.py              # Database operations and persistence
├── school_management.py     # Main CLI application
├── create_demo_data.py      # Script to create sample data
├── .gitignore              # Git ignore file
└── school_data.json        # Data file (created automatically)
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open source and available for educational purposes.

## Contact

For questions or support, please open an issue on GitHub.
