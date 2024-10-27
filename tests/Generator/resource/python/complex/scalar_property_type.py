from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .string_property_type import StringPropertyType
from .integer_property_type import IntegerPropertyType
from .number_property_type import NumberPropertyType
from .boolean_property_type import BooleanPropertyType
from .property_type import PropertyType


# Base scalar property type
class ScalarPropertyType(PropertyType):
    pass

