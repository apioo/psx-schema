from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal
from .common_form_element import CommonFormElement
from .common_form_element_input import CommonFormElementInput
from .common_form_element_select import CommonFormElementSelect
from .common_form_element_tag import CommonFormElementTag
from .common_form_element_text_area import CommonFormElementTextArea


class CommonFormContainer(BaseModel):
    element: List[Union[CommonFormElementInput, CommonFormElementSelect, CommonFormElementTag, CommonFormElementTextArea]] = Field(discriminator="type", default_factory=list, alias="element")
    pass


