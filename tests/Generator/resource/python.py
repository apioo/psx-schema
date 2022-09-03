from typing import Any

# Location of the person
class Location:
    def __init__(self, lat: float, long: float):
        self.lat = lat
        self.long = long

from typing import Any

# An application
class Web:
    def __init__(self, name: str, url: str):
        self.name = name
        self.url = url

from typing import Any
from typing import List

# An simple author element with some description
class Author:
    def __init__(self, title: str, email: str, categories: List[str], locations: List[Location], origin: Location):
        self.title = title
        self.email = email
        self.categories = categories
        self.locations = locations
        self.origin = origin

from typing import Any
from typing import Dict
class Meta(Dict[str, str]):

from typing import Any
from typing import List
from typing import Dict
from typing import Union

# An general news entry
class News:
    def __init__(self, config: Meta, inline_config: Dict[str, str], tags: List[str], receiver: List[Author], resources: List[Union[Location, Web]], profile_image: str, read: bool, source: Union[Author, Web], author: Author, meta: Meta, send_date: str, read_date: str, expires: str, price: float, rating: int, content: str, question: str, version: str, coffee_time: str, profile_uri: str, captcha: str, payload: Any):
        self.config = config
        self.inline_config = inline_config
        self.tags = tags
        self.receiver = receiver
        self.resources = resources
        self.profile_image = profile_image
        self.read = read
        self.source = source
        self.author = author
        self.meta = meta
        self.send_date = send_date
        self.read_date = read_date
        self.expires = expires
        self.price = price
        self.rating = rating
        self.content = content
        self.question = question
        self.version = version
        self.coffee_time = coffee_time
        self.profile_uri = profile_uri
        self.captcha = captcha
        self.payload = payload
