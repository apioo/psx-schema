from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal
from .property_type import PropertyType


# Represents a reference to a definition type
class ReferencePropertyType(PropertyType):
    type: Literal["reference"] = Field(alias="type")
    target: Optional[str] = Field(default=None, alias="target")
    template: Optional[Dict[str, str]] = Field(default=None, alias="template")
    pass


