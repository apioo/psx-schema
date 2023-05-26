@dataclass
class Creature:
    kind: str

from creature import Creature
@dataclass
class Human(Creature):
    first_name: str

from creature import Creature
@dataclass
class Animal(Creature):
    nickname: str

from human import Human
from animal import Animal
@dataclass
class Union:
    union: Union[Human, Animal]
    intersection: Any
    discriminator: Union[Human, Animal]
