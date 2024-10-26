from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .collection_property_type import CollectionPropertyType


# Represents an array which contains a dynamic list of values
class ArrayPropertyType(CollectionPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass


