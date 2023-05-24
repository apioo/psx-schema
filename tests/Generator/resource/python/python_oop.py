from typing import Any
from dataclasses import dataclass
@dataclass
class Human:
    first_name: str

from typing import Any
from dataclasses import dataclass
@dataclass
class Student(Human):
    matricle_number: str

from typing import Any
from dataclasses import dataclass
class StudentMap(Map):

from typing import Any
from dataclasses import dataclass
from typing import List
@dataclass
class Map:
    total_results: int
    entries: List[T]

from typing import Any
from dataclasses import dataclass
@dataclass
class RootSchema:
    students: StudentMap
