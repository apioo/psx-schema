from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
from .argument import Argument
from .response import Response


class Operation(BaseModel):
    arguments: Optional[Dict[str, Argument]] = Field(default=None, alias="arguments")
    authorization: Optional[bool] = Field(default=None, alias="authorization")
    description: Optional[str] = Field(default=None, alias="description")
    method: Optional[str] = Field(default=None, alias="method")
    path: Optional[str] = Field(default=None, alias="path")
    return_: Optional[Response] = Field(default=None, alias="return")
    security: Optional[List[str]] = Field(default=None, alias="security")
    stability: Optional[int] = Field(default=None, alias="stability")
    throws: Optional[List[Response]] = Field(default=None, alias="throws")
    pass


