from typing import Any
from dataclasses import dataclass

# Location of the person
@dataclass
class Location:
    lat: float
    long: float

from typing import Any
from dataclasses import dataclass

# An application
@dataclass
class Web:
    name: str
    url: str

from typing import Any
from dataclasses import dataclass
from typing import List

# An simple author element with some description
@dataclass
class Author:
    title: str
    email: str
    categories: List[str]
    locations: List[Location]
    origin: Location

from typing import Any
from dataclasses import dataclass
from typing import Dict
class Meta(Dict[str, str]):

from typing import Any
from dataclasses import dataclass
from typing import List
from typing import Dict
from typing import Union

# An general news entry
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
