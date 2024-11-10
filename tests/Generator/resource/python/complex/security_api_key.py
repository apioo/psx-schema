from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar
from .security import Security


class SecurityApiKey(Security):
    name: Optional[str] = Field(default=None, alias="name")
    in_: Optional[str] = Field(default=None, alias="in")
    pass


