from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .property_type import PropertyType


# Represents a reference to a definition type
class ReferencePropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    target: Optional[str] = Field(default=None, alias="target")
    pass


