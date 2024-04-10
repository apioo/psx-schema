from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union


# Represents a base type. Every type extends from this common type and shares the defined properties
class CommonType(BaseModel):
    description: Optional[str] = Field(default=None, alias="description")
    type: Optional[str] = Field(default=None, alias="type")
    nullable: Optional[bool] = Field(default=None, alias="nullable")
    deprecated: Optional[bool] = Field(default=None, alias="deprecated")
    readonly: Optional[bool] = Field(default=None, alias="readonly")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .common_type import CommonType


# Represents an any type
class AnyType(CommonType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .common_type import CommonType
from .boolean_type import BooleanType
from .number_type import NumberType
from .string_type import StringType
from .reference_type import ReferenceType
from .generic_type import GenericType
from .any_type import AnyType


# Represents an array type. An array type contains an ordered list of a specific type
class ArrayType(CommonType):
    type: Optional[str] = Field(default=None, alias="type")
    items: Optional[Union[BooleanType, NumberType, StringType, ReferenceType, GenericType, AnyType]] = Field(default=None, alias="items")
    max_items: Optional[int] = Field(default=None, alias="maxItems")
    min_items: Optional[int] = Field(default=None, alias="minItems")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .common_type import CommonType


# Represents a scalar type
class ScalarType(CommonType):
    format: Optional[str] = Field(default=None, alias="format")
    enum: Optional[List[Union[str, float]]] = Field(default=None, alias="enum")
    default: Optional[Union[str, float, bool]] = Field(default=None, alias="default")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .scalar_type import ScalarType


# Represents a boolean type
class BooleanType(ScalarType):
    type: Optional[str] = Field(default=None, alias="type")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union


# Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
class Discriminator(BaseModel):
    property_name: Optional[str] = Field(default=None, alias="propertyName")
    mapping: Optional[Dict[str, str]] = Field(default=None, alias="mapping")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union


# Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
class GenericType(BaseModel):
    _generic: Optional[str] = Field(default=None, alias="$generic")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .reference_type import ReferenceType


# Represents an intersection type
class IntersectionType(BaseModel):
    description: Optional[str] = Field(default=None, alias="description")
    all_of: Optional[List[ReferenceType]] = Field(default=None, alias="allOf")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .common_type import CommonType
from .boolean_type import BooleanType
from .number_type import NumberType
from .string_type import StringType
from .array_type import ArrayType
from .union_type import UnionType
from .intersection_type import IntersectionType
from .reference_type import ReferenceType
from .generic_type import GenericType
from .any_type import AnyType


# Represents a map type. A map type contains variable key value entries of a specific type
class MapType(CommonType):
    type: Optional[str] = Field(default=None, alias="type")
    additional_properties: Optional[Union[BooleanType, NumberType, StringType, ArrayType, UnionType, IntersectionType, ReferenceType, GenericType, AnyType]] = Field(default=None, alias="additionalProperties")
    max_properties: Optional[int] = Field(default=None, alias="maxProperties")
    min_properties: Optional[int] = Field(default=None, alias="minProperties")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .scalar_type import ScalarType


# Represents a number type (contains also integer)
class NumberType(ScalarType):
    type: Optional[str] = Field(default=None, alias="type")
    multiple_of: Optional[float] = Field(default=None, alias="multipleOf")
    maximum: Optional[float] = Field(default=None, alias="maximum")
    exclusive_maximum: Optional[bool] = Field(default=None, alias="exclusiveMaximum")
    minimum: Optional[float] = Field(default=None, alias="minimum")
    exclusive_minimum: Optional[bool] = Field(default=None, alias="exclusiveMinimum")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union


# Represents a reference type. A reference type points to a specific type at the definitions map
class ReferenceType(BaseModel):
    _ref: Optional[str] = Field(default=None, alias="$ref")
    _template: Optional[Dict[str, str]] = Field(default=None, alias="$template")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .scalar_type import ScalarType


# Represents a string type
class StringType(ScalarType):
    type: Optional[str] = Field(default=None, alias="type")
    max_length: Optional[int] = Field(default=None, alias="maxLength")
    min_length: Optional[int] = Field(default=None, alias="minLength")
    pattern: Optional[str] = Field(default=None, alias="pattern")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .common_type import CommonType
from .map_type import MapType
from .array_type import ArrayType
from .boolean_type import BooleanType
from .number_type import NumberType
from .string_type import StringType
from .any_type import AnyType
from .intersection_type import IntersectionType
from .union_type import UnionType
from .reference_type import ReferenceType
from .generic_type import GenericType


# Represents a struct type. A struct type contains a fix set of defined properties
class StructType(CommonType):
    _final: Optional[bool] = Field(default=None, alias="$final")
    _extends: Optional[str] = Field(default=None, alias="$extends")
    type: Optional[str] = Field(default=None, alias="type")
    properties: Optional[Dict[str, Union[MapType, ArrayType, BooleanType, NumberType, StringType, AnyType, IntersectionType, UnionType, ReferenceType, GenericType]]] = Field(default=None, alias="properties")
    required: Optional[List[str]] = Field(default=None, alias="required")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .struct_type import StructType
from .map_type import MapType
from .reference_type import ReferenceType


# The root TypeSchema
class TypeSchema(BaseModel):
    _import: Optional[Dict[str, str]] = Field(default=None, alias="$import")
    definitions: Optional[Dict[str, Union[StructType, MapType, ReferenceType]]] = Field(default=None, alias="definitions")
    _ref: Optional[str] = Field(default=None, alias="$ref")
    pass

from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Union
from .discriminator import Discriminator
from .number_type import NumberType
from .string_type import StringType
from .boolean_type import BooleanType
from .reference_type import ReferenceType


# Represents an union type. An union type can contain one of the provided types
class UnionType(BaseModel):
    description: Optional[str] = Field(default=None, alias="description")
    discriminator: Optional[Discriminator] = Field(default=None, alias="discriminator")
    one_of: Optional[List[Union[NumberType, StringType, BooleanType, ReferenceType]]] = Field(default=None, alias="oneOf")
    pass
