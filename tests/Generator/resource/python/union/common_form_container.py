from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
from .common_form_element import CommonFormElement
from .common_form_element_input import CommonFormElementInput
from .common_form_element_select import CommonFormElementSelect
from .common_form_element_tag import CommonFormElementTag
from .common_form_element_text_area import CommonFormElementTextArea


class CommonFormContainer(BaseModel):
    element: Optional[List[Annotated[Union[Annotated[CommonFormElementInput, Tag('http://fusio-project.org/ns/2015/form/input')], Annotated[CommonFormElementSelect, Tag('http://fusio-project.org/ns/2015/form/select')], Annotated[CommonFormElementTag, Tag('http://fusio-project.org/ns/2015/form/tag')], Annotated[CommonFormElementTextArea, Tag('http://fusio-project.org/ns/2015/form/textarea')]], Field(discriminator='type')]]] = Field(default=None, alias="element")
    pass


