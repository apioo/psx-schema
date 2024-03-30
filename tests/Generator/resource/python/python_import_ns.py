from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from student_map import StudentMap
from student import Student
@dataclass_json
@dataclass
class Import:
    students: My.Import.StudentMap = field(metadata=config(field_name="students"))
    student: My.Import.Student = field(metadata=config(field_name="student"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from student import Student
@dataclass_json
@dataclass
class MyMap(My.Import.Student):
