from dataclasses import dataclass
from typing import Any
@dataclass
class Human:
    first_name: str

from dataclasses import dataclass
from typing import Any
from human import Human
@dataclass
class Student(Human):
    matricle_number: str

from dataclasses import dataclass
from typing import Any
from map import Map
from student import Student
class StudentMap(Map):
    pass

from dataclasses import dataclass
from typing import Any
from typing import List
@dataclass
class Map:
    total_results: int
    entries: List[T]

from dataclasses import dataclass
from typing import Any
from student_map import StudentMap
@dataclass
class RootSchema:
    students: StudentMap
