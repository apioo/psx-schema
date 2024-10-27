from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .property_type import PropertyType


class Argument(BaseModel):
    in_: Optional[str] = Field(default=None, alias="in")
    schema_: Optional[PropertyType] = Field(default=None, alias="schema")
    content_type: Optional[str] = Field(default=None, alias="contentType")
    name: Optional[str] = Field(default=None, alias="name")
    pass


