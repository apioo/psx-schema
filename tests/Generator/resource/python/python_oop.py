from dataclasses import dataclass
@dataclass
class Human:
    first_name: str

from dataclasses import dataclass
from human import Human
@dataclass
class Student(Human):
    matricle_number: str

from dataclasses import dataclass
from map import Map
from student import Student
@dataclass
class StudentMap(Map):
    pass

from dataclasses import dataclass
from typing import List
@dataclass
class Map:
    total_results: int
    entries: List[T]

from dataclasses import dataclass
from student_map import StudentMap
@dataclass
class RootSchema:
    students: StudentMap
