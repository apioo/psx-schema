@dataclass
class Human:
    first_name: str

from human import Human
@dataclass
class Student(Human):
    matricle_number: str

from map import Map
from student import Student
class StudentMap(Map):
    pass

@dataclass
class Map:
    total_results: int
    entries: List[T]

from student_map import StudentMap
@dataclass
class RootSchema:
    students: StudentMap
