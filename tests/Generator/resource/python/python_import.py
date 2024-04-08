from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic
from .student_map import StudentMap
from .student import Student
@dataclass_json
@dataclass
class Import:
    students: StudentMap = data_field(default=None, metadata=json_config(field_name="students"))
    student: Student = data_field(default=None, metadata=json_config(field_name="student"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic
from .student import Student
@dataclass_json
@dataclass
class MyMap(Student):
    pass
