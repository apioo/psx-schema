from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal
from .definition_type import DefinitionType
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


# Base collection type
class CollectionDefinitionType(DefinitionType):
    schema_: Annotated[Union[AnyPropertyType, ArrayPropertyType, BooleanPropertyType, GenericPropertyType, IntegerPropertyType, MapPropertyType, NumberPropertyType, ReferencePropertyType, StringPropertyType], Field(discriminator="type")] = Field(alias="schema")
    pass


