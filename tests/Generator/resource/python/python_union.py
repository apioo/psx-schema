from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
class Creature(BaseModel):
    kind: Optional[str] = Field(default=None, alias="kind")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .creature import Creature
class Human(Creature):
    first_name: Optional[str] = Field(default=None, alias="firstName")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .creature import Creature
class Animal(Creature):
    nickname: Optional[str] = Field(default=None, alias="nickname")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .human import Human
from .animal import Animal
class Union(BaseModel):
    union: Optional[Union[Human, Animal]] = Field(default=None, alias="union")
    intersection: Optional[Any] = Field(default=None, alias="intersection")
    discriminator: Optional[Union[Human, Animal]] = Field(default=None, alias="discriminator")
    pass
