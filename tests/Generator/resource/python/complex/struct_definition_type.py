from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
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
from .reference_property_type import ReferencePropertyType
from .string_property_type import StringPropertyType


# A struct represents a class/structure with a fix set of defined properties.
class StructDefinitionType(DefinitionType):
    base: Optional[bool] = Field(default=None, alias="base")
    discriminator: Optional[str] = Field(default=None, alias="discriminator")
    mapping: Optional[Dict[str, str]] = Field(default=None, alias="mapping")
    parent: Optional[ReferencePropertyType] = Field(default=None, alias="parent")
    properties: Optional[Dict[str, Annotated[Union[Annotated[AnyPropertyType, Tag('any')], Annotated[ArrayPropertyType, Tag('array')], Annotated[BooleanPropertyType, Tag('boolean')], Annotated[GenericPropertyType, Tag('generic')], Annotated[IntegerPropertyType, Tag('integer')], Annotated[MapPropertyType, Tag('map')], Annotated[NumberPropertyType, Tag('number')], Annotated[ReferencePropertyType, Tag('reference')], Annotated[StringPropertyType, Tag('string')]], Field(discriminator='type')]]] = Field(default=None, alias="properties")
    pass


