from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal
from .definition_type import DefinitionType
from .reference_property_type import ReferencePropertyType
from .property_type import PropertyType
from .any_property_type import AnyPropertyType
from .array_property_type import ArrayPropertyType
from .boolean_property_type import BooleanPropertyType
from .generic_property_type import GenericPropertyType
from .integer_property_type import IntegerPropertyType
from .map_property_type import MapPropertyType
from .number_property_type import NumberPropertyType
from .string_property_type import StringPropertyType


# A struct represents a class/structure with a fix set of defined properties
class StructDefinitionType(DefinitionType):
    type: Literal["struct"] = Field(alias="type")
    base: Optional[bool] = Field(default=None, alias="base")
    discriminator: Optional[str] = Field(default=None, alias="discriminator")
    mapping: Optional[Dict[str, str]] = Field(default=None, alias="mapping")
    parent: Optional[ReferencePropertyType] = Field(default=None, alias="parent")
    properties: Dict[str, Annotated[Union["AnyPropertyType", "ArrayPropertyType", "BooleanPropertyType", "GenericPropertyType", "IntegerPropertyType", "MapPropertyType", "NumberPropertyType", "ReferencePropertyType", "StringPropertyType"], Field(discriminator="type")]] = Field(alias="properties")
    pass


