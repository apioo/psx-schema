from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .struct_definition_type import StructDefinitionType
from .map_definition_type import MapDefinitionType
from .array_definition_type import ArrayDefinitionType


# Base definition type
class DefinitionType(BaseModel):
    description: Optional[str] = Field(default=None, alias="description")
    deprecated: Optional[bool] = Field(default=None, alias="deprecated")
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .definition_type import DefinitionType
from .property_type import PropertyType


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
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .map_definition_type import MapDefinitionType
from .array_definition_type import ArrayDefinitionType
from .definition_type import DefinitionType
from .property_type import PropertyType


# Base type for the map and array collection type
class CollectionDefinitionType(DefinitionType):
    type: Optional[str] = Field(default=None, alias="type")
    schema_: Optional[PropertyType] = Field(default=None, alias="schema")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .collection_definition_type import CollectionDefinitionType


# Represents a map which contains a dynamic set of key value entries
class MapDefinitionType(CollectionDefinitionType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .collection_definition_type import CollectionDefinitionType


# Represents an array which contains a dynamic list of values
class ArrayDefinitionType(CollectionDefinitionType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .integer_property_type import IntegerPropertyType
from .number_property_type import NumberPropertyType
from .string_property_type import StringPropertyType
from .boolean_property_type import BooleanPropertyType
from .map_property_type import MapPropertyType
from .array_property_type import ArrayPropertyType
from .any_property_type import AnyPropertyType
from .generic_property_type import GenericPropertyType
from .reference_property_type import ReferencePropertyType


# Base property type
class PropertyType(BaseModel):
    description: Optional[str] = Field(default=None, alias="description")
    deprecated: Optional[bool] = Field(default=None, alias="deprecated")
    type: Optional[str] = Field(default=None, alias="type")
    nullable: Optional[bool] = Field(default=None, alias="nullable")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .integer_property_type import IntegerPropertyType
from .number_property_type import NumberPropertyType
from .string_property_type import StringPropertyType
from .boolean_property_type import BooleanPropertyType
from .property_type import PropertyType


# Base scalar property type
class ScalarPropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .scalar_property_type import ScalarPropertyType


# Represents an integer value
class IntegerPropertyType(ScalarPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .scalar_property_type import ScalarPropertyType


# Represents a float value
class NumberPropertyType(ScalarPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .scalar_property_type import ScalarPropertyType


# Represents a string value
class StringPropertyType(ScalarPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    format: Optional[str] = Field(default=None, alias="format")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .scalar_property_type import ScalarPropertyType


# Represents a boolean value
class BooleanPropertyType(ScalarPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .map_property_type import MapPropertyType
from .array_property_type import ArrayPropertyType
from .property_type import PropertyType


# Base collection property type
class CollectionPropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    schema_: Optional[PropertyType] = Field(default=None, alias="schema")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .collection_property_type import CollectionPropertyType


# Represents a map which contains a dynamic set of key value entries
class MapPropertyType(CollectionPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .collection_property_type import CollectionPropertyType


# Represents an array which contains a dynamic list of values
class ArrayPropertyType(CollectionPropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .property_type import PropertyType


# Represents an any value which allows any kind of value
class AnyPropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .property_type import PropertyType


# Represents a generic value which can be replaced with a dynamic type
class GenericPropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    name: Optional[str] = Field(default=None, alias="name")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .property_type import PropertyType


# Represents a reference to a definition type
class ReferencePropertyType(PropertyType):
    type: Optional[str] = Field(default=None, alias="type")
    target: Optional[str] = Field(default=None, alias="target")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .definition_type import DefinitionType
class Specification(BaseModel):
    import_: Optional[Dict[str, str]] = Field(default=None, alias="import")
    definitions: Optional[Dict[str, DefinitionType]] = Field(default=None, alias="definitions")
    root: Optional[str] = Field(default=None, alias="root")
    pass
