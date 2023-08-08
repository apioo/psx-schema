from dataclasses import dataclass
from dataclasses_json import dataclass_json
@dataclass_json
@dataclass
class Creature:
    kind: str

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from creature import Creature
@dataclass_json
@dataclass
class Human(Creature):
    first_name: str

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from creature import Creature
@dataclass_json
@dataclass
class Animal(Creature):
    nickname: str

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from typing import Union
from human import Human
from animal import Animal
@dataclass_json
@dataclass
class Union:
    union: Union[Human, Animal]
    intersection: Any
    discriminator: Union[Human, Animal]
