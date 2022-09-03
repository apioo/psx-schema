from typing import Any
class Creature:
    def __init__(self, kind: str):
        self.kind = kind

from typing import Any
class Human(Creature):
    def __init__(self, first_name: str):
        self.first_name = first_name

from typing import Any
class Animal(Creature):
    def __init__(self, nickname: str):
        self.nickname = nickname

from typing import Any
from typing import Union
class Union:
    def __init__(self, union: Union[Human, Animal], intersection: , discriminator: Union[Human, Animal]):
        self.union = union
        self.intersection = intersection
        self.discriminator = discriminator
