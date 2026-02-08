# School Management System - Usage Guide

## Quick Start

### 1. First Time Setup

```bash
# Clone the repository
git clone https://github.com/alwuhailimohammed/school-management-system.git
cd school-management-system

# Create demo data (optional but recommended)
python create_demo_data.py
```

### 2. Start the Application

```bash
python school_management.py
```

## Main Features

### Student Management

**Add a New Student:**
1. Select "1" from main menu (Student Management)
2. Select "1" (Add Student)
3. Enter student details:
   - Student ID (e.g., S007)
   - Name (e.g., Ali Mohammed)
   - Grade (e.g., 10)
   - Age (e.g., 15)
   - Parent Contact (e.g., 0771-123-4567)

**View All Students:**
- Navigate to Student Management → View All Students
- Displays a table with ID, Name, Grade, and Age

**View Student Details:**
- Navigate to Student Management → View Student Details
- Enter Student ID
- Shows complete information including enrolled classes

**Update Student:**
- Navigate to Student Management → Update Student
- Enter Student ID
- Update any field (press Enter to keep current value)

**Delete Student:**
- Navigate to Student Management → Delete Student
- Enter Student ID
- Confirm deletion (type "yes")
- System automatically removes student from all enrolled classes

### Teacher Management

**Add a New Teacher:**
1. Select "2" from main menu (Teacher Management)
2. Select "1" (Add Teacher)
3. Enter teacher details:
   - Teacher ID (e.g., T005)
   - Name (e.g., Dr. Ahmed Ibrahim)
   - Subject (e.g., Physics)
   - Contact (e.g., 0750-123-4567)

**View All Teachers:**
- Displays table with ID, Name, and Subject

**View Teacher Details:**
- Shows complete information including assigned classes

**Delete Teacher:**
- System automatically removes teacher from all assigned classes

### Class Management

**Add a New Class:**
1. Select "3" from main menu (Class Management)
2. Select "1" (Add Class)
3. Enter class details:
   - Class ID (e.g., C005)
   - Class Name (e.g., Physics 11A)
   - Grade (e.g., 11)
   - Room Number (e.g., Room 202)

**Assign Teacher to Class:**
1. Navigate to Class Management → Assign Teacher to Class
2. Enter Class ID (e.g., C001)
3. Enter Teacher ID (e.g., T001)
4. If class already has a teacher, the old assignment is properly cleaned up

**Enroll Student in Class:**
1. Navigate to Class Management → Enroll Student in Class
2. Enter Class ID (e.g., C001)
3. Enter Student ID (e.g., S001)
4. System creates bidirectional link between student and class

**View Class Details:**
- Shows class information
- Lists assigned teacher
- Lists all enrolled students

**Delete Class:**
- System automatically removes class from all students and teacher

### Subject Management

**Add a New Subject:**
1. Select "4" from main menu (Subject Management)
2. Select "1" (Add Subject)
3. Enter subject details:
   - Subject ID (e.g., SUB005)
   - Subject Name (e.g., Physics)
   - Description (e.g., Study of matter and energy)

### Reports

**Summary Report:**
- Shows total counts of students, teachers, classes, and subjects

**Students by Grade:**
- Groups and displays all students by their grade level

**Teachers by Subject:**
- Groups and displays all teachers by their subject area

**Classes by Grade:**
- Groups and displays all classes by grade level

## Tips and Best Practices

1. **Backup Your Data:**
   - The `school_data.json` file contains all your data
   - Make regular backups by copying this file

2. **ID Conventions:**
   - Students: S001, S002, S003, etc.
   - Teachers: T001, T002, T003, etc.
   - Classes: C001, C002, C003, etc.
   - Subjects: SUB001, SUB002, SUB003, etc.

3. **Data Integrity:**
   - Always use the delete functions in the application
   - Do not manually edit the school_data.json file
   - The system maintains relationships automatically

4. **Navigation:**
   - Use numeric choices to navigate menus
   - Option "6" (or last option) typically returns to previous menu
   - Type "yes" to confirm deletions

## Troubleshooting

**Problem: "Student/Teacher/Class not found"**
- Solution: Check that you're using the correct ID

**Problem: "Already exists"**
- Solution: Use a different ID or use the update function instead

**Problem: Data lost after restart**
- Solution: Ensure school_data.json file exists and is not corrupted

**Problem: Can't run the program**
- Solution: Make sure you have Python 3.6 or higher installed
- Check: `python --version` or `python3 --version`

## Example Workflow

Here's a complete workflow for setting up a new class:

```
1. Start the application
2. Add a Subject (e.g., Physics - SUB005)
3. Add a Teacher (e.g., Dr. Tariq - T005, Subject: Physics)
4. Add a Class (e.g., Physics 11B - C005, Grade: 11)
5. Assign the teacher to the class
6. Add students or enroll existing students
7. View class details to verify everything is set up correctly
```

## Data Structure Example

After creating the above workflow, your data would look like:

```
Class: Physics 11B (C005)
├── Teacher: Dr. Tariq (T005)
├── Students:
│   ├── Student 1 (S001)
│   ├── Student 2 (S002)
│   └── Student 3 (S003)
└── Room: 202
```

## Contact and Support

For issues or questions:
- Open an issue on GitHub
- Check the README.md for additional information
- Review the code comments in the Python files
