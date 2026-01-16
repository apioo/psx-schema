from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal
from .collection_property_type import CollectionPropertyType


# Represents a map which contains a dynamic set of key value entries of the same type
class MapPropertyType(CollectionPropertyType):
    type: Literal["map"] = Field(alias="type")
    pass


