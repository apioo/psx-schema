from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic


# Represents a base type. Every type extends from this common type and shares the defined properties
@dataclass_json
@dataclass
class CommonType:
    description: str = data_field(default=None, metadata=json_config(field_name="description"))
    type: str = data_field(default=None, metadata=json_config(field_name="type"))
    nullable: bool = data_field(default=None, metadata=json_config(field_name="nullable"))
    deprecated: bool = data_field(default=None, metadata=json_config(field_name="deprecated"))
    readonly: bool = data_field(default=None, metadata=json_config(field_name="readonly"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic
from .common_type import CommonType


# Represents an any type
@dataclass_json
@dataclass
class AnyType(CommonType):
    type: str = data_field(default=None, metadata=json_config(field_name="type"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import Union
from typing import TypeVar, Generic
from .common_type import CommonType
from .boolean_type import BooleanType
from .number_type import NumberType
from .string_type import StringType
from .reference_type import ReferenceType
from .generic_type import GenericType
from .any_type import AnyType


# Represents an array type. An array type contains an ordered list of a specific type
@dataclass_json
@dataclass
class ArrayType(CommonType):
    type: str = data_field(default=None, metadata=json_config(field_name="type"))
    items: Union[BooleanType, NumberType, StringType, ReferenceType, GenericType, AnyType] = data_field(default=None, metadata=json_config(field_name="items"))
    max_items: int = data_field(default=None, metadata=json_config(field_name="maxItems"))
    min_items: int = data_field(default=None, metadata=json_config(field_name="minItems"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import List
from typing import Union
from typing import TypeVar, Generic
from .common_type import CommonType


# Represents a scalar type
@dataclass_json
@dataclass
class ScalarType(CommonType):
    format: str = data_field(default=None, metadata=json_config(field_name="format"))
    enum: List[Union[str, float]] = data_field(default=None, metadata=json_config(field_name="enum"))
    default: Union[str, float, bool] = data_field(default=None, metadata=json_config(field_name="default"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic
from .scalar_type import ScalarType


# Represents a boolean type
@dataclass_json
@dataclass
class BooleanType(ScalarType):
    type: str = data_field(default=None, metadata=json_config(field_name="type"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import Dict
from typing import TypeVar, Generic


# Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
@dataclass_json
@dataclass
class Discriminator:
    property_name: str = data_field(default=None, metadata=json_config(field_name="propertyName"))
    mapping: Dict[str, str] = data_field(default=None, metadata=json_config(field_name="mapping"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic


# Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
@dataclass_json
@dataclass
class GenericType:
    _generic: str = data_field(default=None, metadata=json_config(field_name="$generic"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import List
from typing import TypeVar, Generic
from .reference_type import ReferenceType


# Represents an intersection type
@dataclass_json
@dataclass
class IntersectionType:
    description: str = data_field(default=None, metadata=json_config(field_name="description"))
    all_of: List[ReferenceType] = data_field(default=None, metadata=json_config(field_name="allOf"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import Union
from typing import TypeVar, Generic
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
@dataclass_json
@dataclass
class MapType(CommonType):
    type: str = data_field(default=None, metadata=json_config(field_name="type"))
    additional_properties: Union[BooleanType, NumberType, StringType, ArrayType, UnionType, IntersectionType, ReferenceType, GenericType, AnyType] = data_field(default=None, metadata=json_config(field_name="additionalProperties"))
    max_properties: int = data_field(default=None, metadata=json_config(field_name="maxProperties"))
    min_properties: int = data_field(default=None, metadata=json_config(field_name="minProperties"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic
from .scalar_type import ScalarType


# Represents a number type (contains also integer)
@dataclass_json
@dataclass
class NumberType(ScalarType):
    type: str = data_field(default=None, metadata=json_config(field_name="type"))
    multiple_of: float = data_field(default=None, metadata=json_config(field_name="multipleOf"))
    maximum: float = data_field(default=None, metadata=json_config(field_name="maximum"))
    exclusive_maximum: bool = data_field(default=None, metadata=json_config(field_name="exclusiveMaximum"))
    minimum: float = data_field(default=None, metadata=json_config(field_name="minimum"))
    exclusive_minimum: bool = data_field(default=None, metadata=json_config(field_name="exclusiveMinimum"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import Dict
from typing import TypeVar, Generic


# Represents a reference type. A reference type points to a specific type at the definitions map
@dataclass_json
@dataclass
class ReferenceType:
    _ref: str = data_field(default=None, metadata=json_config(field_name="$ref"))
    _template: Dict[str, str] = data_field(default=None, metadata=json_config(field_name="$template"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import TypeVar, Generic
from .scalar_type import ScalarType


# Represents a string type
@dataclass_json
@dataclass
class StringType(ScalarType):
    type: str = data_field(default=None, metadata=json_config(field_name="type"))
    max_length: int = data_field(default=None, metadata=json_config(field_name="maxLength"))
    min_length: int = data_field(default=None, metadata=json_config(field_name="minLength"))
    pattern: str = data_field(default=None, metadata=json_config(field_name="pattern"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import List
from typing import Dict
from typing import Union
from typing import TypeVar, Generic
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
@dataclass_json
@dataclass
class StructType(CommonType):
    _final: bool = data_field(default=None, metadata=json_config(field_name="$final"))
    _extends: str = data_field(default=None, metadata=json_config(field_name="$extends"))
    type: str = data_field(default=None, metadata=json_config(field_name="type"))
    properties: Dict[str, Union[MapType, ArrayType, BooleanType, NumberType, StringType, AnyType, IntersectionType, UnionType, ReferenceType, GenericType]] = data_field(default=None, metadata=json_config(field_name="properties"))
    required: List[str] = data_field(default=None, metadata=json_config(field_name="required"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import Dict
from typing import Union
from typing import TypeVar, Generic
from .struct_type import StructType
from .map_type import MapType
from .reference_type import ReferenceType


# The root TypeSchema
@dataclass_json
@dataclass
class TypeSchema:
    _import: Dict[str, str] = data_field(default=None, metadata=json_config(field_name="$import"))
    definitions: Dict[str, Union[StructType, MapType, ReferenceType]] = data_field(default=None, metadata=json_config(field_name="definitions"))
    _ref: str = data_field(default=None, metadata=json_config(field_name="$ref"))
    pass

from dataclasses import dataclass
from dataclasses import field as data_field
from dataclasses_json import dataclass_json
from dataclasses_json import config as json_config
from typing import List
from typing import Union
from typing import TypeVar, Generic
from .discriminator import Discriminator
from .number_type import NumberType
from .string_type import StringType
from .boolean_type import BooleanType
from .reference_type import ReferenceType


# Represents an union type. An union type can contain one of the provided types
@dataclass_json
@dataclass
class UnionType:
    description: str = data_field(default=None, metadata=json_config(field_name="description"))
    discriminator: Discriminator = data_field(default=None, metadata=json_config(field_name="discriminator"))
    one_of: List[Union[NumberType, StringType, BooleanType, ReferenceType]] = data_field(default=None, metadata=json_config(field_name="oneOf"))
    pass
