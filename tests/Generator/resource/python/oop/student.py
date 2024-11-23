from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
from .human_type import HumanType


class Student(HumanType):
    matricle_number: Optional[str] = Field(default=None, alias="matricleNumber")
    pass


