from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .property_type import PropertyType
from .string_property_type import StringPropertyType
from .integer_property_type import IntegerPropertyType
from .number_property_type import NumberPropertyType
from .boolean_property_type import BooleanPropertyType
from .map_property_type import MapPropertyType
from .array_property_type import ArrayPropertyType
from .any_property_type import AnyPropertyType
from .generic_property_type import GenericPropertyType
from .reference_property_type import ReferencePropertyType


class Response(BaseModel):
    code: Optional[int] = Field(default=None, alias="code")
    content_type: Optional[str] = Field(default=None, alias="contentType")
    schema_: Optional[Annotated[Union[Annotated[StringPropertyType, Tag('string')], Annotated[IntegerPropertyType, Tag('integer')], Annotated[NumberPropertyType, Tag('number')], Annotated[BooleanPropertyType, Tag('boolean')], Annotated[MapPropertyType, Tag('map')], Annotated[ArrayPropertyType, Tag('array')], Annotated[AnyPropertyType, Tag('any')], Annotated[GenericPropertyType, Tag('generic')], Annotated[ReferencePropertyType, Tag('reference')]], Field(discriminator='type')]
] = Field(default=None, alias="schema")
    pass


