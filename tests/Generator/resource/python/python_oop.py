from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .human import Human
class Human(BaseModel):
    first_name: Optional[str] = Field(default=None, alias="firstName")
    parent: Optional[Human] = Field(default=None, alias="parent")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .human import Human
class Student(Human):
    matricle_number: Optional[str] = Field(default=None, alias="matricleNumber")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .map import Map
from .student import Student
class StudentMap(Map[Student]):
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
T = TypeVar("T")
class Map(BaseModel, Generic[T]):
    total_results: Optional[int] = Field(default=None, alias="totalResults")
    entries: Optional[List[T]] = Field(default=None, alias="entries")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .student_map import StudentMap
class RootSchema(BaseModel):
    students: Optional[StudentMap] = Field(default=None, alias="students")
    pass
