from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
@dataclass_json
@dataclass
class Creature:
    kind: str = field(default=None, metadata=config(field_name="kind"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from creature import Creature
@dataclass_json
@dataclass
class Human(Creature):
    first_name: str = field(default=None, metadata=config(field_name="firstName"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from creature import Creature
@dataclass_json
@dataclass
class Animal(Creature):
    nickname: str = field(default=None, metadata=config(field_name="nickname"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import Union
from human import Human
from animal import Animal
@dataclass_json
@dataclass
class Union:
    union: Union[Human, Animal] = field(default=None, metadata=config(field_name="union"))
    intersection: Any = field(default=None, metadata=config(field_name="intersection"))
    discriminator: Union[Human, Animal] = field(default=None, metadata=config(field_name="discriminator"))
