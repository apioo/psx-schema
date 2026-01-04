from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal


# Location of the person
class Location(BaseModel):
    lat: Optional[float] = Field(default=None, alias="lat")
    long: Optional[float] = Field(default=None, alias="long")
    pass


