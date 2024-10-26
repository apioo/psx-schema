from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict


P = TypeVar("P")
T = TypeVar("T")
class Map(BaseModel, Generic[P], Generic[T]):
    total_results: Optional[int] = Field(default=None, alias="totalResults")
    parent: Optional[P] = Field(default=None, alias="parent")
    entries: Optional[List[T]] = Field(default=None, alias="entries")
    pass


