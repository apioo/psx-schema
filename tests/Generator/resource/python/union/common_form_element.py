from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal


class CommonFormElement(BaseModel):
    element: Optional[str] = Field(default=None, alias="element")
    name: Optional[str] = Field(default=None, alias="name")
    title: Optional[str] = Field(default=None, alias="title")
    help: Optional[str] = Field(default=None, alias="help")
    pass


