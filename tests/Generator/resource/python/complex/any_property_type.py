from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
from .property_type import PropertyType


# Represents an any value which allows any kind of value
class AnyPropertyType(PropertyType):
    pass


