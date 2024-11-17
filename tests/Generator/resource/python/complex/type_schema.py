from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar
from .definition_type import DefinitionType


# TypeSchema specification
class TypeSchema(BaseModel):
    definitions: Optional[Dict[str, DefinitionType]] = Field(default=None, alias="definitions")
    import_: Optional[Dict[str, str]] = Field(default=None, alias="import")
    root: Optional[str] = Field(default=None, alias="root")
    pass


