from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
import datetime
from .meta import Meta
from .author import Author


# An general news entry
class News(BaseModel):
    config: Optional[Meta] = Field(default=None, alias="config")
    inline_config: Optional[Dict[str, str]] = Field(default=None, alias="inlineConfig")
    map_tags: Optional[Dict[str, str]] = Field(default=None, alias="mapTags")
    map_receiver: Optional[Dict[str, Author]] = Field(default=None, alias="mapReceiver")
    tags: Optional[List[str]] = Field(default=None, alias="tags")
    receiver: Optional[List[Author]] = Field(default=None, alias="receiver")
    data: Optional[List[List[float]]] = Field(default=None, alias="data")
    read: Optional[bool] = Field(default=None, alias="read")
    author: Author = Field(alias="author")
    meta: Optional[Meta] = Field(default=None, alias="meta")
    send_date: Optional[datetime.date] = Field(default=None, alias="sendDate")
    read_date: Optional[datetime.datetime] = Field(default=None, alias="readDate")
    price: Optional[float] = Field(default=None, alias="price")
    rating: Optional[int] = Field(default=None, alias="rating")
    content: str = Field(alias="content")
    question: Optional[str] = Field(default=None, alias="question")
    version: Optional[str] = Field(default=None, alias="version")
    coffee_time: Optional[datetime.time] = Field(default=None, alias="coffeeTime")
    captcha: Optional[str] = Field(default=None, alias="g-recaptcha-response")
    media_fields: Optional[str] = Field(default=None, alias="media.fields")
    payload: Optional[Any] = Field(default=None, alias="payload")
    pass


