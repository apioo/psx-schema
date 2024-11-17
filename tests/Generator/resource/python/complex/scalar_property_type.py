from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar
from .boolean_property_type import BooleanPropertyType
from .integer_property_type import IntegerPropertyType
from .number_property_type import NumberPropertyType
from .string_property_type import StringPropertyType
from .property_type import PropertyType


# Base scalar property type
class ScalarPropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass


