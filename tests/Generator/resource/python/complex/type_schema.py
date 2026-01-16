from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal
from .definition_type import DefinitionType
from .array_definition_type import ArrayDefinitionType
from .map_definition_type import MapDefinitionType
from .struct_definition_type import StructDefinitionType


# TypeSchema specification
class TypeSchema(BaseModel):
    definitions: Dict[str, Annotated[Union[ArrayDefinitionType, MapDefinitionType, StructDefinitionType], Field(discriminator="type")]] = Field(alias="definitions")
    import_: Optional[Dict[str, str]] = Field(default=None, alias="import")
    root: Optional[str] = Field(default=None, alias="root")
    pass


