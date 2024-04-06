from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config


# Location of the person
@dataclass_json
@dataclass
class Location:
    lat: float = field(default=None, metadata=config(field_name="lat"))
    long: float = field(default=None, metadata=config(field_name="long"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config


# An application
@dataclass_json
@dataclass
class Web:
    name: str = field(default=None, metadata=config(field_name="name"))
    url: str = field(default=None, metadata=config(field_name="url"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import List
from .location import Location


# An simple author element with some description
@dataclass_json
@dataclass
class Author:
    title: str = field(default=None, metadata=config(field_name="title"))
    email: str = field(default=None, metadata=config(field_name="email"))
    categories: List[str] = field(default=None, metadata=config(field_name="categories"))
    locations: List[Location] = field(default=None, metadata=config(field_name="locations"))
    origin: Location = field(default=None, metadata=config(field_name="origin"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import Dict
class Meta(Dict[str, str]):
    pass

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import Any
from typing import List
from typing import Dict
from typing import Union
from .meta import Meta
from .author import Author
from .location import Location
from .web import Web


# An general news entry
@dataclass_json
@dataclass
class News:
    config: Meta = field(default=None, metadata=config(field_name="config"))
    inline_config: Dict[str, str] = field(default=None, metadata=config(field_name="inlineConfig"))
    map_tags: Dict[str, str] = field(default=None, metadata=config(field_name="mapTags"))
    map_receiver: Dict[str, Author] = field(default=None, metadata=config(field_name="mapReceiver"))
    map_resources: Dict[str, Union[Location, Web]] = field(default=None, metadata=config(field_name="mapResources"))
    tags: List[str] = field(default=None, metadata=config(field_name="tags"))
    receiver: List[Author] = field(default=None, metadata=config(field_name="receiver"))
    resources: List[Union[Location, Web]] = field(default=None, metadata=config(field_name="resources"))
    profile_image: bytearray = field(default=None, metadata=config(field_name="profileImage"))
    read: bool = field(default=None, metadata=config(field_name="read"))
    source: Union[Author, Web] = field(default=None, metadata=config(field_name="source"))
    author: Author = field(default=None, metadata=config(field_name="author"))
    meta: Meta = field(default=None, metadata=config(field_name="meta"))
    send_date: datetime.date = field(default=None, metadata=config(field_name="sendDate"))
    read_date: datetime.datetime = field(default=None, metadata=config(field_name="readDate"))
    expires: datetime.timedelta = field(default=None, metadata=config(field_name="expires"))
    range: datetime.timedelta = field(default=None, metadata=config(field_name="range"))
    price: float = field(default=None, metadata=config(field_name="price"))
    rating: int = field(default=None, metadata=config(field_name="rating"))
    content: str = field(default=None, metadata=config(field_name="content"))
    question: str = field(default=None, metadata=config(field_name="question"))
    version: str = field(default=None, metadata=config(field_name="version"))
    coffee_time: datetime.time = field(default=None, metadata=config(field_name="coffeeTime"))
    profile_uri: str = field(default=None, metadata=config(field_name="profileUri"))
    captcha: str = field(default=None, metadata=config(field_name="g-recaptcha-response"))
    payload: Any = field(default=None, metadata=config(field_name="payload"))
