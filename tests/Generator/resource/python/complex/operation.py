from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar
from .response import Response
from .argument import Argument


class Operation(BaseModel):
    method: Optional[str] = Field(default=None, alias="method")
    path: Optional[str] = Field(default=None, alias="path")
    return_: Optional[Response] = Field(default=None, alias="return")
    arguments: Optional[Dict[str, Argument]] = Field(default=None, alias="arguments")
    throws: Optional[List[Response]] = Field(default=None, alias="throws")
    description: Optional[str] = Field(default=None, alias="description")
    stability: Optional[int] = Field(default=None, alias="stability")
    security: Optional[List[str]] = Field(default=None, alias="security")
    authorization: Optional[bool] = Field(default=None, alias="authorization")
    tags: Optional[List[str]] = Field(default=None, alias="tags")
    pass


