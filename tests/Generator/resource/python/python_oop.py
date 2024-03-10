from dataclasses import dataclass
from dataclasses_json import dataclass_json
from human import Human
@dataclass_json
@dataclass
class Human:
    first_name: str
    parent: Human

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from human import Human
@dataclass_json
@dataclass
class Student(Human):
    matricle_number: str

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from map import Map
from student import Student
@dataclass_json
@dataclass
class StudentMap(Map[Student]):
    pass

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from typing import List
@dataclass_json
@dataclass
class Map:
    total_results: int
    entries: List[T]

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from student_map import StudentMap
@dataclass_json
@dataclass
class RootSchema:
    students: StudentMap
