from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .definition_type import DefinitionType
from .property_type import PropertyType


# Represents a struct which contains a fixed set of defined properties
class StructDefinitionType(DefinitionType):
    type: Optional[str] = Field(default=None, alias="type")
    parent: Optional[str] = Field(default=None, alias="parent")
    base: Optional[bool] = Field(default=None, alias="base")
    properties: Optional[Dict[str, PropertyType]] = Field(default=None, alias="properties")
    discriminator: Optional[str] = Field(default=None, alias="discriminator")
    mapping: Optional[Dict[str, str]] = Field(default=None, alias="mapping")
    template: Optional[Dict[str, str]] = Field(default=None, alias="template")
    pass


