from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Base definition type
class DefinitionType(BaseModel):
    description: Optional[str] = Field(default=None, alias="description")
    deprecated: Optional[bool] = Field(default=None, alias="deprecated")
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Represents a struct which contains a fixed set of defined properties
class StructDefinitionType(DefinitionType):
    type: Optional[str] = Field(default=None, alias="type")
    parent: Optional[str] = Field(default=None, alias="parent")
    base: Optional[bool] = Field(default=None, alias="base")
    properties: Optional[Dict[str, PropertyType]] = Field(default=None, alias="properties")
    discriminator: Optional[str] = Field(default=None, alias="discriminator")
    mapping: Optional[Dict[str, str]] = Field(default=None, alias="mapping")
    template: Optional[Dict[str, str]] = Field(default=None, alias="template")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Base type for the map and array collection type
class CollectionDefinitionType(DefinitionType):
    type: Optional[str] = Field(default=None, alias="type")
    schema_: Optional[PropertyType] = Field(default=None, alias="schema")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Represents a map which contains a dynamic set of key value entries
class MapDefinitionType(CollectionDefinitionType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Represents an array which contains a dynamic list of values
class ArrayDefinitionType(CollectionDefinitionType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Base property type
class PropertyType(BaseModel):
    description: Optional[str] = Field(default=None, alias="description")
    deprecated: Optional[bool] = Field(default=None, alias="deprecated")
    type: Optional[str] = Field(default=None, alias="type")
    nullable: Optional[bool] = Field(default=None, alias="nullable")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Base scalar property type
class ScalarPropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Represents an integer value
class IntegerPropertyType(ScalarPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Represents a float value
class NumberPropertyType(ScalarPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Represents a string value
class StringPropertyType(ScalarPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    format: Optional[str] = Field(default=None, alias="format")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Represents a boolean value
class BooleanPropertyType(ScalarPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Base collection property type
class CollectionPropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    schema_: Optional[PropertyType] = Field(default=None, alias="schema")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Represents a map which contains a dynamic set of key value entries
class MapPropertyType(CollectionPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Represents an array which contains a dynamic list of values
class ArrayPropertyType(CollectionPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Represents an any value which allows any kind of value
class AnyPropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Represents a generic value which can be replaced with a dynamic type
class GenericPropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    name: Optional[str] = Field(default=None, alias="name")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict


# Represents a reference to a definition type
class ReferencePropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    target: Optional[str] = Field(default=None, alias="target")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union, UserList, UserDict
class Specification(BaseModel):
    import_: Optional[Dict[str, str]] = Field(default=None, alias="import")
    definitions: Optional[Dict[str, DefinitionType]] = Field(default=None, alias="definitions")
    root: Optional[str] = Field(default=None, alias="root")
    pass
