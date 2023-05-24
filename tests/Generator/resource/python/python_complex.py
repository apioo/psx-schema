from typing import Any
from dataclasses import dataclass

# Represents a base type. Every type extends from this common type and shares the defined properties
@dataclass
class CommonType:
    description: str
    type: str
    nullable: bool
    deprecated: bool
    readonly: bool

from typing import Any
from dataclasses import dataclass
from typing import List

# Represents a struct type. A struct type contains a fix set of defined properties
@dataclass
class StructType(CommonType):
    _final: bool
    _extends: str
    type: str
    properties: Properties
    required: List[str]

from typing import Any
from dataclasses import dataclass
from typing import Dict
from typing import Union

# Properties of a struct
class Properties(Dict[str, Union[BooleanType, NumberType, StringType, ArrayType, UnionType, IntersectionType, ReferenceType, GenericType, AnyType]]):

from typing import Any
from dataclasses import dataclass
from typing import Union

# Represents a map type. A map type contains variable key value entries of a specific type
@dataclass
class MapType(CommonType):
    type: str
    additional_properties: Union[BooleanType, NumberType, StringType, ArrayType, UnionType, IntersectionType, ReferenceType, GenericType, AnyType]
    max_properties: int
    min_properties: int

from typing import Any
from dataclasses import dataclass
from typing import Union

# Represents an array type. An array type contains an ordered list of a specific type
@dataclass
class ArrayType(CommonType):
    type: str
    items: Union[BooleanType, NumberType, StringType, ReferenceType, GenericType, AnyType]
    max_items: int
    min_items: int

from typing import Any
from dataclasses import dataclass
from typing import List
from typing import Union

# Represents a scalar type
@dataclass
class ScalarType(CommonType):
    format: str
    enum: List[Union[str, float]]
    default: Union[str, float, bool]

from typing import Any
from dataclasses import dataclass

# Represents a boolean type
@dataclass
class BooleanType(ScalarType):
    type: str

from typing import Any
from dataclasses import dataclass

# Represents a number type (contains also integer)
@dataclass
class NumberType(ScalarType):
    type: str
    multiple_of: float
    maximum: float
    exclusive_maximum: bool
    minimum: float
    exclusive_minimum: bool

from typing import Any
from dataclasses import dataclass

# Represents a string type
@dataclass
class StringType(ScalarType):
    type: str
    max_length: int
    min_length: int
    pattern: str

from typing import Any
from dataclasses import dataclass

# Represents an any type
@dataclass
class AnyType(CommonType):
    type: str

from typing import Any
from dataclasses import dataclass
from typing import List

# Represents an intersection type
@dataclass
class IntersectionType:
    description: str
    all_of: List[ReferenceType]

from typing import Any
from dataclasses import dataclass
from typing import List
from typing import Union

# Represents an union type. An union type can contain one of the provided types
@dataclass
class UnionType:
    description: str
    discriminator: Discriminator
    one_of: List[Union[NumberType, StringType, BooleanType, ReferenceType]]

from typing import Any
from dataclasses import dataclass
from typing import Dict

# An object to hold mappings between payload values and schema names or references
class DiscriminatorMapping(Dict[str, str]):

from typing import Any
from dataclasses import dataclass

# Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
@dataclass
class Discriminator:
    property_name: str
    mapping: DiscriminatorMapping

from typing import Any
from dataclasses import dataclass

# Represents a reference type. A reference type points to a specific type at the definitions map
@dataclass
class ReferenceType:
    _ref: str
    _template: TemplateProperties

from typing import Any
from dataclasses import dataclass
from typing import Dict
class TemplateProperties(Dict[str, str]):

from typing import Any
from dataclasses import dataclass

# Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
@dataclass
class GenericType:
    _generic: str

from typing import Any
from dataclasses import dataclass
from typing import Dict
from typing import Union

# The definitions map which contains all types
class Definitions(Dict[str, Union[StructType, MapType, ReferenceType]]):

from typing import Any
from dataclasses import dataclass
from typing import Dict

# Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. 'my_namespace:my_type'
class Import(Dict[str, str]):

from typing import Any
from dataclasses import dataclass

# The root TypeSchema
@dataclass
class TypeSchema:
    _import: Import
    definitions: Definitions
    _ref: str
