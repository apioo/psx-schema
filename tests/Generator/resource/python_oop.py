from typing import Any
class Human:
    def __init__(self, firstName: str):
        self.firstName = firstName

from typing import Any
class Student(Human):
    def __init__(self, matricleNumber: str):
        self.matricleNumber = matricleNumber

from typing import Any
class StudentMap(Map):

from typing import Any
from typing import List
class Map:
    def __init__(self, totalResults: int, entries: List[T]):
        self.totalResults = totalResults
        self.entries = entries

from typing import Any
class RootSchema:
    def __init__(self, students: StudentMap):
        self.students = students
