from dataclasses import dataclass

# Represents a base type. Every type extends from this common type and shares the defined properties
@dataclass
class CommonType:
    description: str
    type: str
    nullable: bool
    deprecated: bool
    readonly: bool

from dataclasses import dataclass
from typing import List
from common_type import CommonType
from properties import Properties

# Represents a struct type. A struct type contains a fix set of defined properties
@dataclass
class StructType(CommonType):
    _final: bool
    _extends: str
    type: str
    properties: Properties
    required: List[str]

from dataclasses import dataclass
from typing import Dict
from typing import Union
from boolean_type import BooleanType
from number_type import NumberType
from string_type import StringType
from array_type import ArrayType
from union_type import UnionType
from intersection_type import IntersectionType
from reference_type import ReferenceType
from generic_type import GenericType
from any_type import AnyType

# Properties of a struct
@dataclass
class Properties(Dict[str, Union[BooleanType, NumberType, StringType, ArrayType, UnionType, IntersectionType, ReferenceType, GenericType, AnyType]]):
    pass

from dataclasses import dataclass
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
@dataclass
class MapType(CommonType):
    type: str
    additional_properties: Union[BooleanType, NumberType, StringType, ArrayType, UnionType, IntersectionType, ReferenceType, GenericType, AnyType]
    max_properties: int
    min_properties: int

from dataclasses import dataclass
from typing import Union
from common_type import CommonType
from boolean_type import BooleanType
from number_type import NumberType
from string_type import StringType
from reference_type import ReferenceType
from generic_type import GenericType
from any_type import AnyType

# Represents an array type. An array type contains an ordered list of a specific type
@dataclass
class ArrayType(CommonType):
    type: str
    items: Union[BooleanType, NumberType, StringType, ReferenceType, GenericType, AnyType]
    max_items: int
    min_items: int

from dataclasses import dataclass
from typing import List
from typing import Union
from common_type import CommonType

# Represents a scalar type
@dataclass
class ScalarType(CommonType):
    format: str
    enum: List[Union[str, float]]
    default: Union[str, float, bool]

from dataclasses import dataclass
from scalar_type import ScalarType

# Represents a boolean type
@dataclass
class BooleanType(ScalarType):
    type: str

from dataclasses import dataclass
from scalar_type import ScalarType

# Represents a number type (contains also integer)
@dataclass
class NumberType(ScalarType):
    type: str
    multiple_of: float
    maximum: float
    exclusive_maximum: bool
    minimum: float
    exclusive_minimum: bool

from dataclasses import dataclass
from scalar_type import ScalarType

# Represents a string type
@dataclass
class StringType(ScalarType):
    type: str
    max_length: int
    min_length: int
    pattern: str

from dataclasses import dataclass
from common_type import CommonType

# Represents an any type
@dataclass
class AnyType(CommonType):
    type: str

from dataclasses import dataclass
from typing import List
from reference_type import ReferenceType

# Represents an intersection type
@dataclass
class IntersectionType:
    description: str
    all_of: List[ReferenceType]

from dataclasses import dataclass
from typing import List
from typing import Union
from discriminator import Discriminator
from number_type import NumberType
from string_type import StringType
from boolean_type import BooleanType
from reference_type import ReferenceType

# Represents an union type. An union type can contain one of the provided types
@dataclass
class UnionType:
    description: str
    discriminator: Discriminator
    one_of: List[Union[NumberType, StringType, BooleanType, ReferenceType]]

from dataclasses import dataclass
from typing import Dict

# An object to hold mappings between payload values and schema names or references
@dataclass
class DiscriminatorMapping(Dict[str, str]):
    pass

from dataclasses import dataclass
from discriminator_mapping import DiscriminatorMapping

# Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
@dataclass
class Discriminator:
    property_name: str
    mapping: DiscriminatorMapping

from dataclasses import dataclass
from template_properties import TemplateProperties

# Represents a reference type. A reference type points to a specific type at the definitions map
@dataclass
class ReferenceType:
    _ref: str
    _template: TemplateProperties

from dataclasses import dataclass
from typing import Dict
@dataclass
class TemplateProperties(Dict[str, str]):
    pass

from dataclasses import dataclass

# Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
@dataclass
class GenericType:
    _generic: str

from dataclasses import dataclass
from typing import Dict
from typing import Union
from struct_type import StructType
from map_type import MapType
from reference_type import ReferenceType

# The definitions map which contains all types
@dataclass
class Definitions(Dict[str, Union[StructType, MapType, ReferenceType]]):
    pass

from dataclasses import dataclass
from typing import Dict

# Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. 'my_namespace:my_type'
@dataclass
class Import(Dict[str, str]):
    pass

from dataclasses import dataclass
from import import Import
from definitions import Definitions

# The root TypeSchema
@dataclass
class TypeSchema:
    _import: Import
    definitions: Definitions
    _ref: str
