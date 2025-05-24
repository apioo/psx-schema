from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
from .location import Location


# An simple author element with some description
class Author(BaseModel):
    title: str = Field(alias="title")
    email: Optional[str] = Field(default=None, alias="email")
    categories: Optional[List[str]] = Field(default=None, alias="categories")
    locations: Optional[List[Location]] = Field(default=None, alias="locations")
    origin: Optional[Location] = Field(default=None, alias="origin")
    pass


