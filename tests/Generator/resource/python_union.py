from typing import Any
from dataclasses import dataclass
@dataclass
class Creature:
    kind: str

from typing import Any
from dataclasses import dataclass
@dataclass
class Human(Creature):
    first_name: str

from typing import Any
from dataclasses import dataclass
@dataclass
class Animal(Creature):
    nickname: str

from typing import Any
from dataclasses import dataclass
from typing import Union
@dataclass
class Union:
    union: Union[Human, Animal]
    intersection: Any
    discriminator: Union[Human, Animal]
