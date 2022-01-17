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
    def __init__(self, config: Meta, inlineConfig: Dict[str, str], tags: List[str], receiver: List[Author], resources: List[Union[Location, Web]], profileImage: str, read: bool, source: Union[Author, Web], author: Author, meta: Meta, sendDate: str, readDate: str, expires: str, price: float, rating: int, content: str, question: str, version: str, coffeeTime: str, profileUri: str, captcha: str, payload: Any):
        self.config = config
        self.inlineConfig = inlineConfig
        self.tags = tags
        self.receiver = receiver
        self.resources = resources
        self.profileImage = profileImage
        self.read = read
        self.source = source
        self.author = author
        self.meta = meta
        self.sendDate = sendDate
        self.readDate = readDate
        self.expires = expires
        self.price = price
        self.rating = rating
        self.content = content
        self.question = question
        self.version = version
        self.coffeeTime = coffeeTime
        self.profileUri = profileUri
        self.captcha = captcha
        self.payload = payload
