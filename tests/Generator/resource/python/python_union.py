from dataclasses import dataclass
from typing import Any
@dataclass
class Creature:
    kind: str

from dataclasses import dataclass
from typing import Any
from creature import Creature
@dataclass
class Human(Creature):
    first_name: str

from dataclasses import dataclass
from typing import Any
from creature import Creature
@dataclass
class Animal(Creature):
    nickname: str

from dataclasses import dataclass
from typing import Any
from typing import Union
from human import Human
from animal import Animal
@dataclass
class Union:
    union: Union[Human, Animal]
    intersection: Any
    discriminator: Union[Human, Animal]
