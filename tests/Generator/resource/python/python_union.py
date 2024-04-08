from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic
@dataclass_json
@dataclass
class Creature:
    kind: str = data_field(default=None, metadata=json_config(field_name="kind"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic
from .creature import Creature
@dataclass_json
@dataclass
class Human(Creature):
    first_name: str = data_field(default=None, metadata=json_config(field_name="firstName"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic
from .creature import Creature
@dataclass_json
@dataclass
class Animal(Creature):
    nickname: str = data_field(default=None, metadata=json_config(field_name="nickname"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import Union
from typing import TypeVar, Generic
from .human import Human
from .animal import Animal
@dataclass_json
@dataclass
class Union:
    union: Union[Human, Animal] = data_field(default=None, metadata=json_config(field_name="union"))
    intersection: Any = data_field(default=None, metadata=json_config(field_name="intersection"))
    discriminator: Union[Human, Animal] = data_field(default=None, metadata=json_config(field_name="discriminator"))
    pass
