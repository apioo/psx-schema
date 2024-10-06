from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .student_map import StudentMap
from .student import Student
class Import(BaseModel):
    students: Optional[My.Import.StudentMap] = Field(default=None, alias="students")
    student: Optional[My.Import.Student] = Field(default=None, alias="student")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .student import Student
class MyMap(My.Import.Student):
    pass
