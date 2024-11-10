from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar
from .definition_type import DefinitionType
from .reference_property_type import ReferencePropertyType
from .property_type import PropertyType


# A struct represents a class/structure with a fix set of defined properties.
class StructDefinitionType(DefinitionType):
    parent: Optional[ReferencePropertyType] = Field(default=None, alias="parent")
    base: Optional[bool] = Field(default=None, alias="base")
    properties: Optional[Dict[str, PropertyType]] = Field(default=None, alias="properties")
    discriminator: Optional[str] = Field(default=None, alias="discriminator")
    mapping: Optional[Dict[str, str]] = Field(default=None, alias="mapping")
    pass


