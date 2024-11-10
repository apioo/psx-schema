from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar
from .scalar_property_type import ScalarPropertyType


# Represents a float value
class NumberPropertyType(ScalarPropertyType):
    pass


