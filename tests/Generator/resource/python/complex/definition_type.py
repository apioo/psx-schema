from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union


# Base definition type
class DefinitionType(BaseModel):
    deprecated: Optional[bool] = Field(default=None, alias="deprecated")
    description: Optional[str] = Field(default=None, alias="description")
    type: Optional[str] = Field(default=None, alias="type")
    pass


