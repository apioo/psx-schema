from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
from .scalar_property_type import ScalarPropertyType


# Represents an integer value
class IntegerPropertyType(ScalarPropertyType):
    pass


