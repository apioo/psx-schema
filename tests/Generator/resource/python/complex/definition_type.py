from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar
from .array_definition_type import ArrayDefinitionType
from .map_definition_type import MapDefinitionType
from .struct_definition_type import StructDefinitionType


# Base definition type
class DefinitionType(BaseModel):
    deprecated: Optional[bool] = Field(default=None, alias="deprecated")
    description: Optional[str] = Field(default=None, alias="description")
    type: Optional[str] = Field(default=None, alias="type")
    pass


