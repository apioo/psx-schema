from dataclasses import dataclass
from dataclasses_json import dataclass_json

# Location of the person
@dataclass_json
@dataclass
class Location:
    lat: float
    long: float

from dataclasses import dataclass
from dataclasses_json import dataclass_json

# An application
@dataclass_json
@dataclass
class Web:
    name: str
    url: str

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from typing import List
from location import Location

# An simple author element with some description
@dataclass_json
@dataclass
class Author:
    title: str
    email: str
    categories: List[str]
    locations: List[Location]
    origin: Location

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from typing import Dict
@dataclass_json
@dataclass
class Meta(Dict[str, str]):
    pass

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from typing import Any
from typing import List
from typing import Dict
from typing import Union
from meta import Meta
from author import Author
from location import Location
from web import Web

# An general news entry
@dataclass_json
@dataclass
class News:
    config: Meta
    inline_config: Dict[str, str]
    tags: List[str]
    receiver: List[Author]
    resources: List[Union[Location, Web]]
    profile_image: str
    read: bool
    source: Union[Author, Web]
    author: Author
    meta: Meta
    send_date: str
    read_date: str
    expires: str
    price: float
    rating: int
    content: str
    question: str
    version: str
    coffee_time: str
    profile_uri: str
    captcha: str
    payload: Any
