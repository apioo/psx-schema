from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .property_type import PropertyType


class Response(BaseModel):
    code: Optional[int] = Field(default=None, alias="code")
    content_type: Optional[str] = Field(default=None, alias="contentType")
    schema_: Optional[PropertyType] = Field(default=None, alias="schema")
    pass


