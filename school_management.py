#!/usr/bin/env python3
"""
School Management System - Command Line Interface
A simple system to manage students, teachers, classes, and subjects
"""
import sys
from database import Database
from models import Student, Teacher, Class, Subject


class SchoolManagementCLI:
    """Command-line interface for the school management system"""
    
    def __init__(self):
        self.db = Database()
    
    def display_menu(self):
        """Display the main menu"""
        print("\n" + "="*50)
        print("School Management System - Iraq")
        print("="*50)
        print("1. Student Management")
        print("2. Teacher Management")
        print("3. Class Management")
        print("4. Subject Management")
        print("5. Reports")
        print("6. Exit")
        print("="*50)
    
    def student_menu(self):
        """Display student management menu"""
        while True:
            print("\n--- Student Management ---")
            print("1. Add Student")
            print("2. View All Students")
            print("3. View Student Details")
            print("4. Update Student")
            print("5. Delete Student")
            print("6. Back to Main Menu")
            
            choice = input("Enter your choice: ").strip()
            
            if choice == "1":
                self.add_student()
            elif choice == "2":
                self.view_all_students()
            elif choice == "3":
                self.view_student_details()
            elif choice == "4":
                self.update_student()
            elif choice == "5":
                self.delete_student()
            elif choice == "6":
                break
            else:
                print("Invalid choice. Please try again.")
    
    def add_student(self):
        """Add a new student"""
        print("\n--- Add New Student ---")
        student_id = input("Student ID: ").strip()
        
        if self.db.get_student(student_id):
            print(f"Error: Student with ID {student_id} already exists.")
            return
        
        name = input("Name: ").strip()
        grade = input("Grade: ").strip()
        age = input("Age: ").strip()
        parent_contact = input("Parent Contact (optional): ").strip()
        
        try:
            age = int(age)
            student = Student(student_id, name, grade, age, parent_contact)
            if self.db.add_student(student):
                print(f"Student {name} added successfully!")
            else:
                print("Error adding student.")
        except ValueError:
            print("Error: Age must be a number.")
    
    def view_all_students(self):
        """View all students"""
        students = self.db.get_all_students()
        
        if not students:
            print("\nNo students found.")
            return
        
        print(f"\n{'ID':<15} {'Name':<25} {'Grade':<10} {'Age':<5}")
        print("-" * 60)
        for student in students:
            print(f"{student.student_id:<15} {student.name:<25} {student.grade:<10} {student.age:<5}")
    
    def view_student_details(self):
        """View details of a specific student"""
        student_id = input("\nEnter Student ID: ").strip()
        student = self.db.get_student(student_id)
        
        if not student:
            print(f"Student with ID {student_id} not found.")
            return
        
        print("\n--- Student Details ---")
        print(f"ID: {student.student_id}")
        print(f"Name: {student.name}")
        print(f"Grade: {student.grade}")
        print(f"Age: {student.age}")
        print(f"Parent Contact: {student.parent_contact}")
        print(f"Enrolled Classes: {', '.join(student.enrolled_classes) if student.enrolled_classes else 'None'}")
    
    def update_student(self):
        """Update student information"""
        student_id = input("\nEnter Student ID to update: ").strip()
        student = self.db.get_student(student_id)
        
        if not student:
            print(f"Student with ID {student_id} not found.")
            return
        
        print(f"\nCurrent Name: {student.name}")
        name = input("New Name (press Enter to keep current): ").strip()
        if name:
            student.name = name
        
        print(f"Current Grade: {student.grade}")
        grade = input("New Grade (press Enter to keep current): ").strip()
        if grade:
            student.grade = grade
        
        print(f"Current Age: {student.age}")
        age = input("New Age (press Enter to keep current): ").strip()
        if age:
            try:
                student.age = int(age)
            except ValueError:
                print("Invalid age. Keeping current value.")
        
        print(f"Current Parent Contact: {student.parent_contact}")
        contact = input("New Parent Contact (press Enter to keep current): ").strip()
        if contact:
            student.parent_contact = contact
        
        if self.db.update_student(student):
            print("Student updated successfully!")
        else:
            print("Error updating student.")
    
    def delete_student(self):
        """Delete a student"""
        student_id = input("\nEnter Student ID to delete: ").strip()
        student = self.db.get_student(student_id)
        
        if not student:
            print(f"Student with ID {student_id} not found.")
            return
        
        confirm = input(f"Are you sure you want to delete {student.name}? (yes/no): ").strip().lower()
        if confirm == "yes":
            # Remove student from all enrolled classes
            for class_id in student.enrolled_classes:
                class_obj = self.db.get_class(class_id)
                if class_obj and student_id in class_obj.students:
                    class_obj.students.remove(student_id)
                    self.db.update_class(class_obj)
            
            if self.db.delete_student(student_id):
                print("Student deleted successfully!")
            else:
                print("Error deleting student.")
        else:
            print("Deletion cancelled.")
    
    def teacher_menu(self):
        """Display teacher management menu"""
        while True:
            print("\n--- Teacher Management ---")
            print("1. Add Teacher")
            print("2. View All Teachers")
            print("3. View Teacher Details")
            print("4. Update Teacher")
            print("5. Delete Teacher")
            print("6. Back to Main Menu")
            
            choice = input("Enter your choice: ").strip()
            
            if choice == "1":
                self.add_teacher()
            elif choice == "2":
                self.view_all_teachers()
            elif choice == "3":
                self.view_teacher_details()
            elif choice == "4":
                self.update_teacher()
            elif choice == "5":
                self.delete_teacher()
            elif choice == "6":
                break
            else:
                print("Invalid choice. Please try again.")
    
    def add_teacher(self):
        """Add a new teacher"""
        print("\n--- Add New Teacher ---")
        teacher_id = input("Teacher ID: ").strip()
        
        if self.db.get_teacher(teacher_id):
            print(f"Error: Teacher with ID {teacher_id} already exists.")
            return
        
        name = input("Name: ").strip()
        subject = input("Subject: ").strip()
        contact = input("Contact (optional): ").strip()
        
        teacher = Teacher(teacher_id, name, subject, contact)
        if self.db.add_teacher(teacher):
            print(f"Teacher {name} added successfully!")
        else:
            print("Error adding teacher.")
    
    def view_all_teachers(self):
        """View all teachers"""
        teachers = self.db.get_all_teachers()
        
        if not teachers:
            print("\nNo teachers found.")
            return
        
        print(f"\n{'ID':<15} {'Name':<25} {'Subject':<20}")
        print("-" * 60)
        for teacher in teachers:
            print(f"{teacher.teacher_id:<15} {teacher.name:<25} {teacher.subject:<20}")
    
    def view_teacher_details(self):
        """View details of a specific teacher"""
        teacher_id = input("\nEnter Teacher ID: ").strip()
        teacher = self.db.get_teacher(teacher_id)
        
        if not teacher:
            print(f"Teacher with ID {teacher_id} not found.")
            return
        
        print("\n--- Teacher Details ---")
        print(f"ID: {teacher.teacher_id}")
        print(f"Name: {teacher.name}")
        print(f"Subject: {teacher.subject}")
        print(f"Contact: {teacher.contact}")
        print(f"Assigned Classes: {', '.join(teacher.assigned_classes) if teacher.assigned_classes else 'None'}")
    
    def update_teacher(self):
        """Update teacher information"""
        teacher_id = input("\nEnter Teacher ID to update: ").strip()
        teacher = self.db.get_teacher(teacher_id)
        
        if not teacher:
            print(f"Teacher with ID {teacher_id} not found.")
            return
        
        print(f"\nCurrent Name: {teacher.name}")
        name = input("New Name (press Enter to keep current): ").strip()
        if name:
            teacher.name = name
        
        print(f"Current Subject: {teacher.subject}")
        subject = input("New Subject (press Enter to keep current): ").strip()
        if subject:
            teacher.subject = subject
        
        print(f"Current Contact: {teacher.contact}")
        contact = input("New Contact (press Enter to keep current): ").strip()
        if contact:
            teacher.contact = contact
        
        if self.db.update_teacher(teacher):
            print("Teacher updated successfully!")
        else:
            print("Error updating teacher.")
    
    def delete_teacher(self):
        """Delete a teacher"""
        teacher_id = input("\nEnter Teacher ID to delete: ").strip()
        teacher = self.db.get_teacher(teacher_id)
        
        if not teacher:
            print(f"Teacher with ID {teacher_id} not found.")
            return
        
        confirm = input(f"Are you sure you want to delete {teacher.name}? (yes/no): ").strip().lower()
        if confirm == "yes":
            # Remove teacher from all assigned classes
            for class_id in teacher.assigned_classes:
                class_obj = self.db.get_class(class_id)
                if class_obj and class_obj.teacher_id == teacher_id:
                    class_obj.teacher_id = None
                    self.db.update_class(class_obj)
            
            if self.db.delete_teacher(teacher_id):
                print("Teacher deleted successfully!")
            else:
                print("Error deleting teacher.")
        else:
            print("Deletion cancelled.")
    
    def class_menu(self):
        """Display class management menu"""
        while True:
            print("\n--- Class Management ---")
            print("1. Add Class")
            print("2. View All Classes")
            print("3. View Class Details")
            print("4. Assign Teacher to Class")
            print("5. Enroll Student in Class")
            print("6. Delete Class")
            print("7. Back to Main Menu")
            
            choice = input("Enter your choice: ").strip()
            
            if choice == "1":
                self.add_class()
            elif choice == "2":
                self.view_all_classes()
            elif choice == "3":
                self.view_class_details()
            elif choice == "4":
                self.assign_teacher_to_class()
            elif choice == "5":
                self.enroll_student_in_class()
            elif choice == "6":
                self.delete_class()
            elif choice == "7":
                break
            else:
                print("Invalid choice. Please try again.")
    
    def add_class(self):
        """Add a new class"""
        print("\n--- Add New Class ---")
        class_id = input("Class ID: ").strip()
        
        if self.db.get_class(class_id):
            print(f"Error: Class with ID {class_id} already exists.")
            return
        
        name = input("Class Name: ").strip()
        grade = input("Grade: ").strip()
        room = input("Room Number (optional): ").strip()
        
        class_obj = Class(class_id, name, grade, room)
        if self.db.add_class(class_obj):
            print(f"Class {name} added successfully!")
        else:
            print("Error adding class.")
    
    def view_all_classes(self):
        """View all classes"""
        classes = self.db.get_all_classes()
        
        if not classes:
            print("\nNo classes found.")
            return
        
        print(f"\n{'ID':<15} {'Name':<25} {'Grade':<10} {'Room':<10}")
        print("-" * 65)
        for class_obj in classes:
            print(f"{class_obj.class_id:<15} {class_obj.name:<25} {class_obj.grade:<10} {class_obj.room:<10}")
    
    def view_class_details(self):
        """View details of a specific class"""
        class_id = input("\nEnter Class ID: ").strip()
        class_obj = self.db.get_class(class_id)
        
        if not class_obj:
            print(f"Class with ID {class_id} not found.")
            return
        
        print("\n--- Class Details ---")
        print(f"ID: {class_obj.class_id}")
        print(f"Name: {class_obj.name}")
        print(f"Grade: {class_obj.grade}")
        print(f"Room: {class_obj.room}")
        
        if class_obj.teacher_id:
            teacher = self.db.get_teacher(class_obj.teacher_id)
            print(f"Teacher: {teacher.name if teacher else 'Unknown'}")
        else:
            print("Teacher: Not assigned")
        
        print(f"Number of Students: {len(class_obj.students)}")
        if class_obj.students:
            print("Students:")
            for student_id in class_obj.students:
                student = self.db.get_student(student_id)
                if student:
                    print(f"  - {student.name} ({student_id})")
    
    def assign_teacher_to_class(self):
        """Assign a teacher to a class"""
        class_id = input("\nEnter Class ID: ").strip()
        class_obj = self.db.get_class(class_id)
        
        if not class_obj:
            print(f"Class with ID {class_id} not found.")
            return
        
        teacher_id = input("Enter Teacher ID: ").strip()
        teacher = self.db.get_teacher(teacher_id)
        
        if not teacher:
            print(f"Teacher with ID {teacher_id} not found.")
            return
        
        # Remove class from previous teacher if exists
        if class_obj.teacher_id:
            old_teacher = self.db.get_teacher(class_obj.teacher_id)
            if old_teacher and class_id in old_teacher.assigned_classes:
                old_teacher.assigned_classes.remove(class_id)
                self.db.update_teacher(old_teacher)
        
        class_obj.teacher_id = teacher_id
        if class_id not in teacher.assigned_classes:
            teacher.assigned_classes.append(class_id)
        
        self.db.update_class(class_obj)
        self.db.update_teacher(teacher)
        print(f"Teacher {teacher.name} assigned to class {class_obj.name} successfully!")
    
    def enroll_student_in_class(self):
        """Enroll a student in a class"""
        class_id = input("\nEnter Class ID: ").strip()
        class_obj = self.db.get_class(class_id)
        
        if not class_obj:
            print(f"Class with ID {class_id} not found.")
            return
        
        student_id = input("Enter Student ID: ").strip()
        student = self.db.get_student(student_id)
        
        if not student:
            print(f"Student with ID {student_id} not found.")
            return
        
        if student_id in class_obj.students:
            print(f"Student {student.name} is already enrolled in this class.")
            return
        
        class_obj.students.append(student_id)
        if class_id not in student.enrolled_classes:
            student.enrolled_classes.append(class_id)
        
        self.db.update_class(class_obj)
        self.db.update_student(student)
        print(f"Student {student.name} enrolled in class {class_obj.name} successfully!")
    
    def delete_class(self):
        """Delete a class"""
        class_id = input("\nEnter Class ID to delete: ").strip()
        class_obj = self.db.get_class(class_id)
        
        if not class_obj:
            print(f"Class with ID {class_id} not found.")
            return
        
        confirm = input(f"Are you sure you want to delete {class_obj.name}? (yes/no): ").strip().lower()
        if confirm == "yes":
            # Remove class from all enrolled students
            for student_id in class_obj.students:
                student = self.db.get_student(student_id)
                if student and class_id in student.enrolled_classes:
                    student.enrolled_classes.remove(class_id)
                    self.db.update_student(student)
            
            # Remove class from assigned teacher
            if class_obj.teacher_id:
                teacher = self.db.get_teacher(class_obj.teacher_id)
                if teacher and class_id in teacher.assigned_classes:
                    teacher.assigned_classes.remove(class_id)
                    self.db.update_teacher(teacher)
            
            if self.db.delete_class(class_id):
                print("Class deleted successfully!")
            else:
                print("Error deleting class.")
        else:
            print("Deletion cancelled.")
    
    def subject_menu(self):
        """Display subject management menu"""
        while True:
            print("\n--- Subject Management ---")
            print("1. Add Subject")
            print("2. View All Subjects")
            print("3. View Subject Details")
            print("4. Delete Subject")
            print("5. Back to Main Menu")
            
            choice = input("Enter your choice: ").strip()
            
            if choice == "1":
                self.add_subject()
            elif choice == "2":
                self.view_all_subjects()
            elif choice == "3":
                self.view_subject_details()
            elif choice == "4":
                self.delete_subject()
            elif choice == "5":
                break
            else:
                print("Invalid choice. Please try again.")
    
    def add_subject(self):
        """Add a new subject"""
        print("\n--- Add New Subject ---")
        subject_id = input("Subject ID: ").strip()
        
        if self.db.get_subject(subject_id):
            print(f"Error: Subject with ID {subject_id} already exists.")
            return
        
        name = input("Subject Name: ").strip()
        description = input("Description (optional): ").strip()
        
        subject = Subject(subject_id, name, description)
        if self.db.add_subject(subject):
            print(f"Subject {name} added successfully!")
        else:
            print("Error adding subject.")
    
    def view_all_subjects(self):
        """View all subjects"""
        subjects = self.db.get_all_subjects()
        
        if not subjects:
            print("\nNo subjects found.")
            return
        
        print(f"\n{'ID':<15} {'Name':<30}")
        print("-" * 45)
        for subject in subjects:
            print(f"{subject.subject_id:<15} {subject.name:<30}")
    
    def view_subject_details(self):
        """View details of a specific subject"""
        subject_id = input("\nEnter Subject ID: ").strip()
        subject = self.db.get_subject(subject_id)
        
        if not subject:
            print(f"Subject with ID {subject_id} not found.")
            return
        
        print("\n--- Subject Details ---")
        print(f"ID: {subject.subject_id}")
        print(f"Name: {subject.name}")
        print(f"Description: {subject.description}")
        print(f"Classes: {', '.join(subject.classes) if subject.classes else 'None'}")
    
    def delete_subject(self):
        """Delete a subject"""
        subject_id = input("\nEnter Subject ID to delete: ").strip()
        subject = self.db.get_subject(subject_id)
        
        if not subject:
            print(f"Subject with ID {subject_id} not found.")
            return
        
        confirm = input(f"Are you sure you want to delete {subject.name}? (yes/no): ").strip().lower()
        if confirm == "yes":
            if self.db.delete_subject(subject_id):
                print("Subject deleted successfully!")
            else:
                print("Error deleting subject.")
        else:
            print("Deletion cancelled.")
    
    def reports_menu(self):
        """Display reports menu"""
        while True:
            print("\n--- Reports ---")
            print("1. Summary Report")
            print("2. Students by Grade")
            print("3. Teachers by Subject")
            print("4. Classes by Grade")
            print("5. Back to Main Menu")
            
            choice = input("Enter your choice: ").strip()
            
            if choice == "1":
                self.summary_report()
            elif choice == "2":
                self.students_by_grade()
            elif choice == "3":
                self.teachers_by_subject()
            elif choice == "4":
                self.classes_by_grade()
            elif choice == "5":
                break
            else:
                print("Invalid choice. Please try again.")
    
    def summary_report(self):
        """Display summary report"""
        print("\n--- School Summary Report ---")
        print(f"Total Students: {len(self.db.get_all_students())}")
        print(f"Total Teachers: {len(self.db.get_all_teachers())}")
        print(f"Total Classes: {len(self.db.get_all_classes())}")
        print(f"Total Subjects: {len(self.db.get_all_subjects())}")
    
    def students_by_grade(self):
        """Display students grouped by grade"""
        students = self.db.get_all_students()
        
        if not students:
            print("\nNo students found.")
            return
        
        grades = {}
        for student in students:
            if student.grade not in grades:
                grades[student.grade] = []
            grades[student.grade].append(student)
        
        print("\n--- Students by Grade ---")
        for grade in sorted(grades.keys()):
            print(f"\nGrade {grade} ({len(grades[grade])} students):")
            for student in grades[grade]:
                print(f"  - {student.name} ({student.student_id})")
    
    def teachers_by_subject(self):
        """Display teachers grouped by subject"""
        teachers = self.db.get_all_teachers()
        
        if not teachers:
            print("\nNo teachers found.")
            return
        
        subjects = {}
        for teacher in teachers:
            if teacher.subject not in subjects:
                subjects[teacher.subject] = []
            subjects[teacher.subject].append(teacher)
        
        print("\n--- Teachers by Subject ---")
        for subject in sorted(subjects.keys()):
            print(f"\n{subject} ({len(subjects[subject])} teachers):")
            for teacher in subjects[subject]:
                print(f"  - {teacher.name} ({teacher.teacher_id})")
    
    def classes_by_grade(self):
        """Display classes grouped by grade"""
        classes = self.db.get_all_classes()
        
        if not classes:
            print("\nNo classes found.")
            return
        
        grades = {}
        for class_obj in classes:
            if class_obj.grade not in grades:
                grades[class_obj.grade] = []
            grades[class_obj.grade].append(class_obj)
        
        print("\n--- Classes by Grade ---")
        for grade in sorted(grades.keys()):
            print(f"\nGrade {grade} ({len(grades[grade])} classes):")
            for class_obj in grades[grade]:
                print(f"  - {class_obj.name} ({class_obj.class_id}) - Room {class_obj.room}")
    
    def run(self):
        """Run the main application loop"""
        print("\nWelcome to the School Management System!")
        
        while True:
            self.display_menu()
            choice = input("Enter your choice: ").strip()
            
            if choice == "1":
                self.student_menu()
            elif choice == "2":
                self.teacher_menu()
            elif choice == "3":
                self.class_menu()
            elif choice == "4":
                self.subject_menu()
            elif choice == "5":
                self.reports_menu()
            elif choice == "6":
                print("\nThank you for using the School Management System!")
                print("Goodbye!")
                sys.exit(0)
            else:
                print("Invalid choice. Please try again.")


if __name__ == "__main__":
    app = SchoolManagementCLI()
    app.run()
