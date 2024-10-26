from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .map_property_type import MapPropertyType
from .array_property_type import ArrayPropertyType
from .property_type import PropertyType


# Base collection property type
class CollectionPropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    schema_: Optional[PropertyType] = Field(default=None, alias="schema")
    pass


