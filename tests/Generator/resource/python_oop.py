from typing import Any
class Human:
    def __init__(self, first_name: str):
        self.first_name = first_name

from typing import Any
class Student(Human):
    def __init__(self, matricle_number: str):
        self.matricle_number = matricle_number

from typing import Any
class StudentMap(Map):

from typing import Any
from typing import List
class Map:
    def __init__(self, total_results: int, entries: List[T]):
        self.total_results = total_results
        self.entries = entries

from typing import Any
class RootSchema:
    def __init__(self, students: StudentMap):
        self.students = students
