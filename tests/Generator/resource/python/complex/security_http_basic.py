from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal
from .security import Security


class SecurityHttpBasic(Security):
    type: Literal["httpBasic"] = Field(alias="type")
    pass


