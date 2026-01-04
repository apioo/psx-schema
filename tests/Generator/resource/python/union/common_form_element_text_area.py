from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal
from .common_form_element import CommonFormElement


class CommonFormElementTextArea(CommonFormElement):
    type: Literal["http://fusio-project.org/ns/2015/form/textarea"] = Field(alias="type")
    mode: Optional[str] = Field(default=None, alias="mode")
    pass


