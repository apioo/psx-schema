from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal
from .common_form_element import CommonFormElement
from .common_form_element_select_option import CommonFormElementSelectOption


class CommonFormElementSelect(CommonFormElement):
    options: Optional[List[CommonFormElementSelectOption]] = Field(default=None, alias="options")
    pass


