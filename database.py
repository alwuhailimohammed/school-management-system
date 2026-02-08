"""
Database manager for the School Management System
Handles data persistence using JSON files
"""
import json
import os
from typing import Dict, List, Optional
from models import Student, Teacher, Class, Subject


class Database:
    """Manages data persistence for the school management system"""
    
    def __init__(self, data_file: str = "school_data.json"):
        self.data_file = data_file
        self.data = {
            "students": {},
            "teachers": {},
            "classes": {},
            "subjects": {}
        }
        self.load()
    
    def load(self):
        """Load data from JSON file"""
        if os.path.exists(self.data_file):
            try:
                with open(self.data_file, 'r', encoding='utf-8') as f:
                    data = json.load(f)
                    
                # Load students
                self.data["students"] = {
                    sid: Student.from_dict(sdata)
                    for sid, sdata in data.get("students", {}).items()
                }
                
                # Load teachers
                self.data["teachers"] = {
                    tid: Teacher.from_dict(tdata)
                    for tid, tdata in data.get("teachers", {}).items()
                }
                
                # Load classes
                self.data["classes"] = {
                    cid: Class.from_dict(cdata)
                    for cid, cdata in data.get("classes", {}).items()
                }
                
                # Load subjects
                self.data["subjects"] = {
                    sid: Subject.from_dict(sdata)
                    for sid, sdata in data.get("subjects", {}).items()
                }
            except Exception as e:
                print(f"Error loading data: {e}")
                print("Starting with empty database.")
    
    def save(self):
        """Save data to JSON file"""
        data = {
            "students": {sid: s.to_dict() for sid, s in self.data["students"].items()},
            "teachers": {tid: t.to_dict() for tid, t in self.data["teachers"].items()},
            "classes": {cid: c.to_dict() for cid, c in self.data["classes"].items()},
            "subjects": {sid: s.to_dict() for sid, s in self.data["subjects"].items()}
        }
        
        with open(self.data_file, 'w', encoding='utf-8') as f:
            json.dump(data, f, indent=2, ensure_ascii=False)
    
    # Student operations
    def add_student(self, student: Student) -> bool:
        """Add a new student"""
        if student.student_id in self.data["students"]:
            return False
        self.data["students"][student.student_id] = student
        self.save()
        return True
    
    def get_student(self, student_id: str) -> Optional[Student]:
        """Get a student by ID"""
        return self.data["students"].get(student_id)
    
    def get_all_students(self) -> List[Student]:
        """Get all students"""
        return list(self.data["students"].values())
    
    def update_student(self, student: Student) -> bool:
        """Update an existing student"""
        if student.student_id not in self.data["students"]:
            return False
        self.data["students"][student.student_id] = student
        self.save()
        return True
    
    def delete_student(self, student_id: str) -> bool:
        """Delete a student"""
        if student_id not in self.data["students"]:
            return False
        del self.data["students"][student_id]
        self.save()
        return True
    
    # Teacher operations
    def add_teacher(self, teacher: Teacher) -> bool:
        """Add a new teacher"""
        if teacher.teacher_id in self.data["teachers"]:
            return False
        self.data["teachers"][teacher.teacher_id] = teacher
        self.save()
        return True
    
    def get_teacher(self, teacher_id: str) -> Optional[Teacher]:
        """Get a teacher by ID"""
        return self.data["teachers"].get(teacher_id)
    
    def get_all_teachers(self) -> List[Teacher]:
        """Get all teachers"""
        return list(self.data["teachers"].values())
    
    def update_teacher(self, teacher: Teacher) -> bool:
        """Update an existing teacher"""
        if teacher.teacher_id not in self.data["teachers"]:
            return False
        self.data["teachers"][teacher.teacher_id] = teacher
        self.save()
        return True
    
    def delete_teacher(self, teacher_id: str) -> bool:
        """Delete a teacher"""
        if teacher_id not in self.data["teachers"]:
            return False
        del self.data["teachers"][teacher_id]
        self.save()
        return True
    
    # Class operations
    def add_class(self, class_obj: Class) -> bool:
        """Add a new class"""
        if class_obj.class_id in self.data["classes"]:
            return False
        self.data["classes"][class_obj.class_id] = class_obj
        self.save()
        return True
    
    def get_class(self, class_id: str) -> Optional[Class]:
        """Get a class by ID"""
        return self.data["classes"].get(class_id)
    
    def get_all_classes(self) -> List[Class]:
        """Get all classes"""
        return list(self.data["classes"].values())
    
    def update_class(self, class_obj: Class) -> bool:
        """Update an existing class"""
        if class_obj.class_id not in self.data["classes"]:
            return False
        self.data["classes"][class_obj.class_id] = class_obj
        self.save()
        return True
    
    def delete_class(self, class_id: str) -> bool:
        """Delete a class"""
        if class_id not in self.data["classes"]:
            return False
        del self.data["classes"][class_id]
        self.save()
        return True
    
    # Subject operations
    def add_subject(self, subject: Subject) -> bool:
        """Add a new subject"""
        if subject.subject_id in self.data["subjects"]:
            return False
        self.data["subjects"][subject.subject_id] = subject
        self.save()
        return True
    
    def get_subject(self, subject_id: str) -> Optional[Subject]:
        """Get a subject by ID"""
        return self.data["subjects"].get(subject_id)
    
    def get_all_subjects(self) -> List[Subject]:
        """Get all subjects"""
        return list(self.data["subjects"].values())
    
    def update_subject(self, subject: Subject) -> bool:
        """Update an existing subject"""
        if subject.subject_id not in self.data["subjects"]:
            return False
        self.data["subjects"][subject.subject_id] = subject
        self.save()
        return True
    
    def delete_subject(self, subject_id: str) -> bool:
        """Delete a subject"""
        if subject_id not in self.data["subjects"]:
            return False
        del self.data["subjects"][subject_id]
        self.save()
        return True
