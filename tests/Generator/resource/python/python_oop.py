from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .human import Human
class Human(BaseModel):
    first_name: Optional[str] = Field(default=None, alias="firstName")
    parent: Optional[Human] = Field(default=None, alias="parent")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .human import Human
class Student(Human):
    matricle_number: Optional[str] = Field(default=None, alias="matricleNumber")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
P = TypeVar("P")
T = TypeVar("T")
class Map(BaseModel, Generic[P], Generic[T]):
    total_results: Optional[int] = Field(default=None, alias="totalResults")
    parent: Optional[P] = Field(default=None, alias="parent")
    entries: Optional[List[T]] = Field(default=None, alias="entries")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .map import Map
from .human import Human
from .student import Student
class StudentMap(Map[Human, Student]):
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .map import Map
from .human import Human
class HumanMap(Map[Human, Human]):
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .student_map import StudentMap
class RootSchema(BaseModel):
    students: Optional[StudentMap] = Field(default=None, alias="students")
    pass
