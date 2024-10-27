from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .struct_definition_type import StructDefinitionType
from .map_definition_type import MapDefinitionType
from .array_definition_type import ArrayDefinitionType


# Base definition type
class DefinitionType(BaseModel):
    description: Optional[str] = Field(default=None, alias="description")
    type: Optional[str] = Field(default=None, alias="type")
    deprecated: Optional[bool] = Field(default=None, alias="deprecated")
    pass

