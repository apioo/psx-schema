from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal
from my.import import StudentMap
from my.import import Student


class Import(BaseModel):
    students: Optional[StudentMap] = Field(default=None, alias="students")
    student: Optional[Student] = Field(default=None, alias="student")
    pass


