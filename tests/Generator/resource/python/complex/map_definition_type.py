from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
from .collection_definition_type import CollectionDefinitionType


# Represents a map which contains a dynamic set of key value entries of the same type
class MapDefinitionType(CollectionDefinitionType):
    pass


