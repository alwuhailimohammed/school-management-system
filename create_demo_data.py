#!/usr/bin/env python3
"""
Demo data script to populate the school management system with sample data
"""
from database import Database
from models import Student, Teacher, Class, Subject


def create_demo_data():
    """Create demo data for the school management system"""
    db = Database()
    
    print("Creating demo data for School Management System...")
    
    # Add students
    students = [
        Student("S001", "Ahmed Ali", "10", 16, "0771-234-5678"),
        Student("S002", "Fatima Hassan", "10", 15, "0750-123-4567"),
        Student("S003", "Mohammed Ibrahim", "11", 17, "0771-987-6543"),
        Student("S004", "Sara Khalid", "11", 16, "0750-456-7890"),
        Student("S005", "Omar Abdullah", "12", 18, "0771-345-6789"),
        Student("S006", "Layla Mahmoud", "12", 17, "0750-678-9012"),
    ]
    
    for student in students:
        db.add_student(student)
        print(f"  Added student: {student.name}")
    
    # Add teachers
    teachers = [
        Teacher("T001", "Dr. Karim Youssef", "Mathematics", "0771-111-2222"),
        Teacher("T002", "Mrs. Nadia Salem", "Arabic", "0750-333-4444"),
        Teacher("T003", "Mr. Tariq Nasser", "Science", "0771-555-6666"),
        Teacher("T004", "Ms. Huda Rashid", "English", "0750-777-8888"),
    ]
    
    for teacher in teachers:
        db.add_teacher(teacher)
        print(f"  Added teacher: {teacher.name}")
    
    # Add classes
    classes = [
        Class("C001", "Mathematics 10A", "10", "Room 101"),
        Class("C002", "Arabic 10A", "10", "Room 102"),
        Class("C003", "Science 11A", "11", "Room 201"),
        Class("C004", "English 12A", "12", "Room 301"),
    ]
    
    for class_obj in classes:
        db.add_class(class_obj)
        print(f"  Added class: {class_obj.name}")
    
    # Add subjects
    subjects = [
        Subject("SUB001", "Mathematics", "Study of numbers, quantities, and shapes"),
        Subject("SUB002", "Arabic", "Arabic language and literature"),
        Subject("SUB003", "Science", "Natural sciences including physics, chemistry, and biology"),
        Subject("SUB004", "English", "English language and literature"),
    ]
    
    for subject in subjects:
        db.add_subject(subject)
        print(f"  Added subject: {subject.name}")
    
    # Assign teachers to classes
    print("\nAssigning teachers to classes...")
    class_c001 = db.get_class("C001")
    class_c001.teacher_id = "T001"
    db.update_class(class_c001)
    teacher = db.get_teacher("T001")
    teacher.assigned_classes.append("C001")
    db.update_teacher(teacher)
    print(f"  {teacher.name} -> {class_c001.name}")
    
    class_c002 = db.get_class("C002")
    class_c002.teacher_id = "T002"
    db.update_class(class_c002)
    teacher = db.get_teacher("T002")
    teacher.assigned_classes.append("C002")
    db.update_teacher(teacher)
    print(f"  {teacher.name} -> {class_c002.name}")
    
    # Enroll students in classes
    print("\nEnrolling students in classes...")
    
    # Enroll S001 and S002 in C001 and C002 (Grade 10)
    for student_id in ["S001", "S002"]:
        for class_id in ["C001", "C002"]:
            student = db.get_student(student_id)
            class_obj = db.get_class(class_id)
            class_obj.students.append(student_id)
            student.enrolled_classes.append(class_id)
            db.update_class(class_obj)
            db.update_student(student)
            print(f"  {student.name} -> {class_obj.name}")
    
    # Enroll S003 and S004 in C003 (Grade 11)
    for student_id in ["S003", "S004"]:
        class_obj = db.get_class("C003")
        student = db.get_student(student_id)
        class_obj.students.append(student_id)
        student.enrolled_classes.append("C003")
        db.update_class(class_obj)
        db.update_student(student)
        print(f"  {student.name} -> {class_obj.name}")
    
    # Enroll S005 and S006 in C004 (Grade 12)
    for student_id in ["S005", "S006"]:
        class_obj = db.get_class("C004")
        student = db.get_student(student_id)
        class_obj.students.append(student_id)
        student.enrolled_classes.append("C004")
        db.update_class(class_obj)
        db.update_student(student)
        print(f"  {student.name} -> {class_obj.name}")
    
    print("\n✓ Demo data created successfully!")
    print("You can now run 'python school_management.py' to use the system.")


if __name__ == "__main__":
    create_demo_data()
