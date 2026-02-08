"""
Data models for the School Management System
"""
from typing import List, Optional


class Student:
    """Represents a student in the school"""
    
    def __init__(self, student_id: str, name: str, grade: str, age: int, 
                 parent_contact: str = ""):
        self.student_id = student_id
        self.name = name
        self.grade = grade
        self.age = age
        self.parent_contact = parent_contact
        self.enrolled_classes: List[str] = []
    
    def to_dict(self):
        return {
            "student_id": self.student_id,
            "name": self.name,
            "grade": self.grade,
            "age": self.age,
            "parent_contact": self.parent_contact,
            "enrolled_classes": self.enrolled_classes
        }
    
    @classmethod
    def from_dict(cls, data):
        student = cls(
            data["student_id"],
            data["name"],
            data["grade"],
            data["age"],
            data.get("parent_contact", "")
        )
        student.enrolled_classes = data.get("enrolled_classes", [])
        return student


class Teacher:
    """Represents a teacher in the school"""
    
    def __init__(self, teacher_id: str, name: str, subject: str, 
                 contact: str = ""):
        self.teacher_id = teacher_id
        self.name = name
        self.subject = subject
        self.contact = contact
        self.assigned_classes: List[str] = []
    
    def to_dict(self):
        return {
            "teacher_id": self.teacher_id,
            "name": self.name,
            "subject": self.subject,
            "contact": self.contact,
            "assigned_classes": self.assigned_classes
        }
    
    @classmethod
    def from_dict(cls, data):
        teacher = cls(
            data["teacher_id"],
            data["name"],
            data["subject"],
            data.get("contact", "")
        )
        teacher.assigned_classes = data.get("assigned_classes", [])
        return teacher


class Class:
    """Represents a class in the school"""
    
    def __init__(self, class_id: str, name: str, grade: str, room: str = ""):
        self.class_id = class_id
        self.name = name
        self.grade = grade
        self.room = room
        self.students: List[str] = []
        self.teacher_id: Optional[str] = None
    
    def to_dict(self):
        return {
            "class_id": self.class_id,
            "name": self.name,
            "grade": self.grade,
            "room": self.room,
            "students": self.students,
            "teacher_id": self.teacher_id
        }
    
    @classmethod
    def from_dict(cls, data):
        class_obj = cls(
            data["class_id"],
            data["name"],
            data["grade"],
            data.get("room", "")
        )
        class_obj.students = data.get("students", [])
        class_obj.teacher_id = data.get("teacher_id")
        return class_obj


class Subject:
    """Represents a subject taught in the school"""
    
    def __init__(self, subject_id: str, name: str, description: str = ""):
        self.subject_id = subject_id
        self.name = name
        self.description = description
        self.classes: List[str] = []
    
    def to_dict(self):
        return {
            "subject_id": self.subject_id,
            "name": self.name,
            "description": self.description,
            "classes": self.classes
        }
    
    @classmethod
    def from_dict(cls, data):
        subject = cls(
            data["subject_id"],
            data["name"],
            data.get("description", "")
        )
        subject.classes = data.get("classes", [])
        return subject
