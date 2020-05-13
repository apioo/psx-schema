class Human:
    def __init__(self, firstName: str):
        self.firstName = firstName

class Student(Human):
    def __init__(self, matricleNumber: str):
        self.matricleNumber = matricleNumber

class StudentMap(Map):

class Map:
    def __init__(self, totalResults: int, entries: List[T]):
        self.totalResults = totalResults
        self.entries = entries

class RootSchema:
    def __init__(self, students: StudentMap):
        self.students = students
