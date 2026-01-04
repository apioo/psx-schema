from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal
from .property_type import PropertyType
from .any_property_type import AnyPropertyType
from .array_property_type import ArrayPropertyType
from .boolean_property_type import BooleanPropertyType
from .generic_property_type import GenericPropertyType
from .integer_property_type import IntegerPropertyType
from .map_property_type import MapPropertyType
from .number_property_type import NumberPropertyType
from .reference_property_type import ReferencePropertyType
from .string_property_type import StringPropertyType


# Describes arguments of the operation
class Argument(BaseModel):
    content_type: Optional[str] = Field(default=None, alias="contentType")
    in_: Optional[str] = Field(default=None, alias="in")
    name: Optional[str] = Field(default=None, alias="name")
    schema_: Union[TypeschemaAnyPropertyType, TypeschemaArrayPropertyType, TypeschemaBooleanPropertyType, TypeschemaGenericPropertyType, TypeschemaIntegerPropertyType, TypeschemaMapPropertyType, TypeschemaNumberPropertyType, TypeschemaReferencePropertyType, TypeschemaStringPropertyType] = Field(discriminator="type", alias="schema")
    pass


