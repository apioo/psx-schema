# Location of the person
@dataclass
class Location:
    lat: float
    long: float

# An application
@dataclass
class Web:
    name: str
    url: str

from location import Location

# An simple author element with some description
@dataclass
class Author:
    title: str
    email: str
    categories: List[str]
    locations: List[Location]
    origin: Location

class Meta(Dict[str, str]):
    pass

from meta import Meta
from author import Author
from location import Location
from web import Web

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
