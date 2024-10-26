from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .collection_definition_type import CollectionDefinitionType


# Represents a map which contains a dynamic set of key value entries
class MapDefinitionType(CollectionDefinitionType):
    type: Optional[str] = Field(default=None, alias="type")
    pass


