from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .human import Human


class Human(BaseModel):
    first_name: Optional[str] = Field(default=None, alias="firstName")
    parent: Optional[Human] = Field(default=None, alias="parent")
    pass


