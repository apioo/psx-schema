from dataclasses import dataclass
from dataclasses_json import dataclass_json

# Represents a base type. Every type extends from this common type and shares the defined properties
@dataclass_json
@dataclass
class CommonType:
    description: str
    type: str
    nullable: bool
    deprecated: bool
    readonly: bool

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from common_type import CommonType

# Represents an any type
@dataclass_json
@dataclass
class AnyType(CommonType):
    type: str

from dataclasses import dataclass
from dataclasses_json import dataclass_json
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
    type: str
    items: Union[BooleanType, NumberType, StringType, ReferenceType, GenericType, AnyType]
    max_items: int
    min_items: int

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from typing import List
from typing import Union
from common_type import CommonType

# Represents a scalar type
@dataclass_json
@dataclass
class ScalarType(CommonType):
    format: str
    enum: List[Union[str, float]]
    default: Union[str, float, bool]

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from scalar_type import ScalarType

# Represents a boolean type
@dataclass_json
@dataclass
class BooleanType(ScalarType):
    type: str

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from typing import Dict

# Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
@dataclass_json
@dataclass
class Discriminator:
    property_name: str
    mapping: Dict[str, str]

from dataclasses import dataclass
from dataclasses_json import dataclass_json

# Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
@dataclass_json
@dataclass
class GenericType:
    _generic: str

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from typing import List
from reference_type import ReferenceType

# Represents an intersection type
@dataclass_json
@dataclass
class IntersectionType:
    description: str
    all_of: List[ReferenceType]

from dataclasses import dataclass
from dataclasses_json import dataclass_json
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
    type: str
    additional_properties: Union[BooleanType, NumberType, StringType, ArrayType, UnionType, IntersectionType, ReferenceType, GenericType, AnyType]
    max_properties: int
    min_properties: int

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from scalar_type import ScalarType

# Represents a number type (contains also integer)
@dataclass_json
@dataclass
class NumberType(ScalarType):
    type: str
    multiple_of: float
    maximum: float
    exclusive_maximum: bool
    minimum: float
    exclusive_minimum: bool

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from typing import Dict

# Represents a reference type. A reference type points to a specific type at the definitions map
@dataclass_json
@dataclass
class ReferenceType:
    _ref: str
    _template: Dict[str, str]

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from scalar_type import ScalarType

# Represents a string type
@dataclass_json
@dataclass
class StringType(ScalarType):
    type: str
    max_length: int
    min_length: int
    pattern: str

from dataclasses import dataclass
from dataclasses_json import dataclass_json
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
    _final: bool
    _extends: str
    type: str
    properties: Dict[str, Union[MapType, ArrayType, BooleanType, NumberType, StringType, AnyType, IntersectionType, UnionType, ReferenceType, GenericType]]
    required: List[str]

from dataclasses import dataclass
from dataclasses_json import dataclass_json
from typing import Dict
from typing import Union
from struct_type import StructType
from map_type import MapType
from reference_type import ReferenceType

# The root TypeSchema
@dataclass_json
@dataclass
class TypeSchema:
    _import: Dict[str, str]
    definitions: Dict[str, Union[StructType, MapType, ReferenceType]]
    _ref: str

from dataclasses import dataclass
from dataclasses_json import dataclass_json
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
    description: str
    discriminator: Discriminator
    one_of: List[Union[NumberType, StringType, BooleanType, ReferenceType]]
