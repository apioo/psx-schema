from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from .student_map import StudentMap
from .student import Student
@dataclass_json
@dataclass
class Import:
    students: StudentMap = field(default=None, metadata=config(field_name="students"))
    student: Student = field(default=None, metadata=config(field_name="student"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from .student import Student
@dataclass_json
@dataclass
class MyMap(Student):
