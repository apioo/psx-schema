from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal
from .scalar_property_type import ScalarPropertyType


# Represents a float value
class NumberPropertyType(ScalarPropertyType):
    type: Literal["number"] = Field(alias="type")
    pass


