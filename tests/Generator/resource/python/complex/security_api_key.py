from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
from .security import Security


class SecurityApiKey(Security):
    in_: Optional[str] = Field(default=None, alias="in")
    name: Optional[str] = Field(default=None, alias="name")
    pass


