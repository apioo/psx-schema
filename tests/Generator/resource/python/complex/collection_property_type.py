from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar
from .array_property_type import ArrayPropertyType
from .map_property_type import MapPropertyType
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


# Base collection property type
class CollectionPropertyType(PropertyType):
    schema_: Optional[Annotated[Union[Annotated[AnyPropertyType, Tag('any')], Annotated[ArrayPropertyType, Tag('array')], Annotated[BooleanPropertyType, Tag('boolean')], Annotated[GenericPropertyType, Tag('generic')], Annotated[IntegerPropertyType, Tag('integer')], Annotated[MapPropertyType, Tag('map')], Annotated[NumberPropertyType, Tag('number')], Annotated[ReferencePropertyType, Tag('reference')], Annotated[StringPropertyType, Tag('string')]], Field(discriminator='type')]
] = Field(default=None, alias="schema")
    type: Optional[str] = Field(default=None, alias="type")
    pass


