from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import TypeVar, Generic
from .human import Human
@dataclass_json
@dataclass
class Human:
    first_name: str = field(default=None, metadata=config(field_name="firstName"))
    parent: Human = field(default=None, metadata=config(field_name="parent"))
    pass

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import TypeVar, Generic
from .human import Human
@dataclass_json
@dataclass
class Student(Human):
    matricle_number: str = field(default=None, metadata=config(field_name="matricleNumber"))
    pass

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import TypeVar, Generic
from .map import Map
from .student import Student
@dataclass_json
@dataclass
class StudentMap(Map[Student]):
    pass

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import List
from typing import TypeVar, Generic
T = TypeVar("T")
@dataclass_json
@dataclass
class Map(Generic[T]):
    total_results: int = field(default=None, metadata=config(field_name="totalResults"))
    entries: List[T] = field(default=None, metadata=config(field_name="entries"))
    pass

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import TypeVar, Generic
from .student_map import StudentMap
@dataclass_json
@dataclass
class RootSchema:
    students: StudentMap = field(default=None, metadata=config(field_name="students"))
    pass
