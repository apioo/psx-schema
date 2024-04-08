from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic


# Location of the person
@dataclass_json
@dataclass
class Location:
    lat: float = data_field(default=None, metadata=json_config(field_name="lat"))
    long: float = data_field(default=None, metadata=json_config(field_name="long"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic


# An application
@dataclass_json
@dataclass
class Web:
    name: str = data_field(default=None, metadata=json_config(field_name="name"))
    url: str = data_field(default=None, metadata=json_config(field_name="url"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import List
from typing import TypeVar, Generic
from .location import Location


# An simple author element with some description
@dataclass_json
@dataclass
class Author:
    title: str = data_field(default=None, metadata=json_config(field_name="title"))
    email: str = data_field(default=None, metadata=json_config(field_name="email"))
    categories: List[str] = data_field(default=None, metadata=json_config(field_name="categories"))
    locations: List[Location] = data_field(default=None, metadata=json_config(field_name="locations"))
    origin: Location = data_field(default=None, metadata=json_config(field_name="origin"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import Dict
from typing import TypeVar, Generic
class Meta(Dict[str, str]):
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import Any
from typing import List
from typing import Dict
from typing import Union
from typing import TypeVar, Generic
import datetime
from .meta import Meta
from .author import Author
from .location import Location
from .web import Web


# An general news entry
@dataclass_json
@dataclass
class News:
    config: Meta = data_field(default=None, metadata=json_config(field_name="config"))
    inline_config: Dict[str, str] = data_field(default=None, metadata=json_config(field_name="inlineConfig"))
    map_tags: Dict[str, str] = data_field(default=None, metadata=json_config(field_name="mapTags"))
    map_receiver: Dict[str, Author] = data_field(default=None, metadata=json_config(field_name="mapReceiver"))
    map_resources: Dict[str, Union[Location, Web]] = data_field(default=None, metadata=json_config(field_name="mapResources"))
    tags: List[str] = data_field(default=None, metadata=json_config(field_name="tags"))
    receiver: List[Author] = data_field(default=None, metadata=json_config(field_name="receiver"))
    resources: List[Union[Location, Web]] = data_field(default=None, metadata=json_config(field_name="resources"))
    profile_image: bytearray = data_field(default=None, metadata=json_config(field_name="profileImage"))
    read: bool = data_field(default=None, metadata=json_config(field_name="read"))
    source: Union[Author, Web] = data_field(default=None, metadata=json_config(field_name="source"))
    author: Author = data_field(default=None, metadata=json_config(field_name="author"))
    meta: Meta = data_field(default=None, metadata=json_config(field_name="meta"))
    send_date: datetime.date = data_field(default=None, metadata=json_config(field_name="sendDate"))
    read_date: datetime.datetime = data_field(default=None, metadata=json_config(field_name="readDate"))
    expires: str = data_field(default=None, metadata=json_config(field_name="expires"))
    range: str = data_field(default=None, metadata=json_config(field_name="range"))
    price: float = data_field(default=None, metadata=json_config(field_name="price"))
    rating: int = data_field(default=None, metadata=json_config(field_name="rating"))
    content: str = data_field(default=None, metadata=json_config(field_name="content"))
    question: str = data_field(default=None, metadata=json_config(field_name="question"))
    version: str = data_field(default=None, metadata=json_config(field_name="version"))
    coffee_time: datetime.time = data_field(default=None, metadata=json_config(field_name="coffeeTime"))
    profile_uri: str = data_field(default=None, metadata=json_config(field_name="profileUri"))
    captcha: str = data_field(default=None, metadata=json_config(field_name="g-recaptcha-response"))
    payload: Any = data_field(default=None, metadata=json_config(field_name="payload"))
    pass
