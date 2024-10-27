from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .type_schema import TypeSchema
from .security import Security
from .operation import Operation


# The TypeAPI Root
class TypeAPI(TypeSchema):
    base_url: Optional[str] = Field(default=None, alias="baseUrl")
    security: Optional[Security] = Field(default=None, alias="security")
    operations: Optional[Dict[str, Operation]] = Field(default=None, alias="operations")
    pass


