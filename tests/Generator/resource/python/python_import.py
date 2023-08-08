from dataclasses import dataclass
from dataclasses_json import dataclass_json
from student_map import StudentMap
from student import Student
@dataclass_json
@dataclass
class Import:
    students: StudentMap
    student: Student

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from student import Student
@dataclass_json
@dataclass
class MyMap(Student):
