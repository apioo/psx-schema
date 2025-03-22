from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
from .property_type import PropertyType


# Base scalar property type
class ScalarPropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass


