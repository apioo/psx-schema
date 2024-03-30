from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config


# Represents a base type. Every type extends from this common type and shares the defined properties
@dataclass_json
@dataclass
class CommonType:
    description: str = field(metadata=config(field_name="description"))
    type: str = field(metadata=config(field_name="type"))
    nullable: bool = field(metadata=config(field_name="nullable"))
    deprecated: bool = field(metadata=config(field_name="deprecated"))
    readonly: bool = field(metadata=config(field_name="readonly"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from common_type import CommonType


# Represents an any type
@dataclass_json
@dataclass
class AnyType(CommonType):
    type: str = field(metadata=config(field_name="type"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import Union
from common_type import CommonType
from boolean_type import BooleanType
from number_type import NumberType
from string_type import StringType
from reference_type import ReferenceType
from generic_type import GenericType
from any_type import AnyType


# Represents an array type. An array type contains an ordered list of a specific type
@dataclass_json
@dataclass
class ArrayType(CommonType):
    type: str = field(metadata=config(field_name="type"))
    items: Union[BooleanType, NumberType, StringType, ReferenceType, GenericType, AnyType] = field(metadata=config(field_name="items"))
    max_items: int = field(metadata=config(field_name="maxItems"))
    min_items: int = field(metadata=config(field_name="minItems"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import List
from typing import Union
from common_type import CommonType


# Represents a scalar type
@dataclass_json
@dataclass
class ScalarType(CommonType):
    format: str = field(metadata=config(field_name="format"))
    enum: List[Union[str, float]] = field(metadata=config(field_name="enum"))
    default: Union[str, float, bool] = field(metadata=config(field_name="default"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from scalar_type import ScalarType


# Represents a boolean type
@dataclass_json
@dataclass
class BooleanType(ScalarType):
    type: str = field(metadata=config(field_name="type"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import Dict


# Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
@dataclass_json
@dataclass
class Discriminator:
    property_name: str = field(metadata=config(field_name="propertyName"))
    mapping: Dict[str, str] = field(metadata=config(field_name="mapping"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config


# Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
@dataclass_json
@dataclass
class GenericType:
    _generic: str = field(metadata=config(field_name="$generic"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import List
from reference_type import ReferenceType


# Represents an intersection type
@dataclass_json
@dataclass
class IntersectionType:
    description: str = field(metadata=config(field_name="description"))
    all_of: List[ReferenceType] = field(metadata=config(field_name="allOf"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import Union
from common_type import CommonType
from boolean_type import BooleanType
from number_type import NumberType
from string_type import StringType
from array_type import ArrayType
from union_type import UnionType
from intersection_type import IntersectionType
from reference_type import ReferenceType
from generic_type import GenericType
from any_type import AnyType


# Represents a map type. A map type contains variable key value entries of a specific type
@dataclass_json
@dataclass
class MapType(CommonType):
    type: str = field(metadata=config(field_name="type"))
    additional_properties: Union[BooleanType, NumberType, StringType, ArrayType, UnionType, IntersectionType, ReferenceType, GenericType, AnyType] = field(metadata=config(field_name="additionalProperties"))
    max_properties: int = field(metadata=config(field_name="maxProperties"))
    min_properties: int = field(metadata=config(field_name="minProperties"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from scalar_type import ScalarType


# Represents a number type (contains also integer)
@dataclass_json
@dataclass
class NumberType(ScalarType):
    type: str = field(metadata=config(field_name="type"))
    multiple_of: float = field(metadata=config(field_name="multipleOf"))
    maximum: float = field(metadata=config(field_name="maximum"))
    exclusive_maximum: bool = field(metadata=config(field_name="exclusiveMaximum"))
    minimum: float = field(metadata=config(field_name="minimum"))
    exclusive_minimum: bool = field(metadata=config(field_name="exclusiveMinimum"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import Dict


# Represents a reference type. A reference type points to a specific type at the definitions map
@dataclass_json
@dataclass
class ReferenceType:
    _ref: str = field(metadata=config(field_name="$ref"))
    _template: Dict[str, str] = field(metadata=config(field_name="$template"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from scalar_type import ScalarType


# Represents a string type
@dataclass_json
@dataclass
class StringType(ScalarType):
    type: str = field(metadata=config(field_name="type"))
    max_length: int = field(metadata=config(field_name="maxLength"))
    min_length: int = field(metadata=config(field_name="minLength"))
    pattern: str = field(metadata=config(field_name="pattern"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import List
from typing import Dict
from typing import Union
from common_type import CommonType
from map_type import MapType
from array_type import ArrayType
from boolean_type import BooleanType
from number_type import NumberType
from string_type import StringType
from any_type import AnyType
from intersection_type import IntersectionType
from union_type import UnionType
from reference_type import ReferenceType
from generic_type import GenericType


# Represents a struct type. A struct type contains a fix set of defined properties
@dataclass_json
@dataclass
class StructType(CommonType):
    _final: bool = field(metadata=config(field_name="$final"))
    _extends: str = field(metadata=config(field_name="$extends"))
    type: str = field(metadata=config(field_name="type"))
    properties: Dict[str, Union[MapType, ArrayType, BooleanType, NumberType, StringType, AnyType, IntersectionType, UnionType, ReferenceType, GenericType]] = field(metadata=config(field_name="properties"))
    required: List[str] = field(metadata=config(field_name="required"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import Dict
from typing import Union
from struct_type import StructType
from map_type import MapType
from reference_type import ReferenceType


# The root TypeSchema
@dataclass_json
@dataclass
class TypeSchema:
    _import: Dict[str, str] = field(metadata=config(field_name="$import"))
    definitions: Dict[str, Union[StructType, MapType, ReferenceType]] = field(metadata=config(field_name="definitions"))
    _ref: str = field(metadata=config(field_name="$ref"))

from dataclasses import dataclass, field
from dataclasses_json import dataclass_json, config
from typing import List
from typing import Union
from discriminator import Discriminator
from number_type import NumberType
from string_type import StringType
from boolean_type import BooleanType
from reference_type import ReferenceType


# Represents an union type. An union type can contain one of the provided types
@dataclass_json
@dataclass
class UnionType:
    description: str = field(metadata=config(field_name="description"))
    discriminator: Discriminator = field(metadata=config(field_name="discriminator"))
    one_of: List[Union[NumberType, StringType, BooleanType, ReferenceType]] = field(metadata=config(field_name="oneOf"))
