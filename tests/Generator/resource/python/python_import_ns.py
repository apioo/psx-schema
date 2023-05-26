from dataclasses import dataclass
from student_map import StudentMap
from student import Student
@dataclass
class Import:
    students: My.Import.StudentMap
    student: My.Import.Student

from dataclasses import dataclass
from student import Student
@dataclass
class MyMap(My.Import.Student):
