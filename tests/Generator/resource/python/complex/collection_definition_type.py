from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .map_definition_type import MapDefinitionType
from .array_definition_type import ArrayDefinitionType
from .definition_type import DefinitionType
from .property_type import PropertyType


# Base collection type
class CollectionDefinitionType(DefinitionType):
    schema_: Optional[PropertyType] = Field(default=None, alias="schema")
    pass


