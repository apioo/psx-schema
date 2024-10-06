from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict
class Import(BaseModel):
    students: Optional[StudentMap] = Field(default=None, alias="students")
    student: Optional[Student] = Field(default=None, alias="student")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict
class MyMap(Student):
    pass
