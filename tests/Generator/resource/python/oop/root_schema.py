from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
from .student_map import StudentMap


class RootSchema(BaseModel):
    students: Optional[StudentMap] = Field(default=None, alias="students")
    pass


