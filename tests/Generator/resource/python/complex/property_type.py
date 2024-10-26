from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .integer_property_type import IntegerPropertyType
from .number_property_type import NumberPropertyType
from .string_property_type import StringPropertyType
from .boolean_property_type import BooleanPropertyType
from .map_property_type import MapPropertyType
from .array_property_type import ArrayPropertyType
from .any_property_type import AnyPropertyType
from .generic_property_type import GenericPropertyType
from .reference_property_type import ReferencePropertyType


# Base property type
class PropertyType(BaseModel):
    description: Optional[str] = Field(default=None, alias="description")
    deprecated: Optional[bool] = Field(default=None, alias="deprecated")
    type: Optional[str] = Field(default=None, alias="type")
    nullable: Optional[bool] = Field(default=None, alias="nullable")
    pass


