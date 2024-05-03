from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union


# Location of the person
class Location(BaseModel):
    lat: Optional[float] = Field(default=None, alias="lat")
    long: Optional[float] = Field(default=None, alias="long")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union


# An application
class Web(BaseModel):
    name: Optional[str] = Field(default=None, alias="name")
    url: Optional[str] = Field(default=None, alias="url")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .location import Location


# An simple author element with some description
class Author(BaseModel):
    title: Optional[str] = Field(default=None, alias="title")
    email: Optional[str] = Field(default=None, alias="email")
    categories: Optional[List[str]] = Field(default=None, alias="categories")
    locations: Optional[List[Location]] = Field(default=None, alias="locations")
    origin: Optional[Location] = Field(default=None, alias="origin")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
class Meta(Dict[str, str]):
    @classmethod
    def __get_pydantic_core_schema__(cls, source_type: Any, handler: GetCoreSchemaHandler) -> CoreSchema:
        return core_schema.dict_schema(handler.generate_schema(str), handler.generate_schema(str))

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
import datetime
from .meta import Meta
from .author import Author
from .location import Location
from .web import Web


# An general news entry
class News(BaseModel):
    config: Optional[Meta] = Field(default=None, alias="config")
    inline_config: Optional[Dict[str, str]] = Field(default=None, alias="inlineConfig")
    map_tags: Optional[Dict[str, str]] = Field(default=None, alias="mapTags")
    map_receiver: Optional[Dict[str, Author]] = Field(default=None, alias="mapReceiver")
    map_resources: Optional[Dict[str, Union[Location, Web]]] = Field(default=None, alias="mapResources")
    tags: Optional[List[str]] = Field(default=None, alias="tags")
    receiver: Optional[List[Author]] = Field(default=None, alias="receiver")
    resources: Optional[List[Union[Location, Web]]] = Field(default=None, alias="resources")
    profile_image: Optional[bytearray] = Field(default=None, alias="profileImage")
    read: Optional[bool] = Field(default=None, alias="read")
    source: Optional[Union[Author, Web]] = Field(default=None, alias="source")
    author: Optional[Author] = Field(default=None, alias="author")
    meta: Optional[Meta] = Field(default=None, alias="meta")
    send_date: Optional[datetime.date] = Field(default=None, alias="sendDate")
    read_date: Optional[datetime.datetime] = Field(default=None, alias="readDate")
    expires: Optional[str] = Field(default=None, alias="expires")
    range: Optional[str] = Field(default=None, alias="range")
    price: Optional[float] = Field(default=None, alias="price")
    rating: Optional[int] = Field(default=None, alias="rating")
    content: Optional[str] = Field(default=None, alias="content")
    question: Optional[str] = Field(default=None, alias="question")
    version: Optional[str] = Field(default=None, alias="version")
    coffee_time: Optional[datetime.time] = Field(default=None, alias="coffeeTime")
    profile_uri: Optional[str] = Field(default=None, alias="profileUri")
    captcha: Optional[str] = Field(default=None, alias="g-recaptcha-response")
    media_fields: Optional[str] = Field(default=None, alias="media.fields")
    payload: Optional[Any] = Field(default=None, alias="payload")
    pass
