from typing import Any
from dataclasses import dataclass

# Common properties which can be used at any schema
@dataclass
class CommonProperties:
    title: str
    description: str
    type: str
    nullable: bool
    deprecated: bool
    readonly: bool

from typing import Any
from dataclasses import dataclass
@dataclass
class ScalarProperties:
    format: str
    enum: Union[StringArray, NumberArray]
    default: Union[str, float, bool]

from typing import Any
from dataclasses import dataclass
from typing import Dict

# Properties of a schema
class Properties(Dict[str, PropertyValue]):

from typing import Any
from dataclasses import dataclass

# Properties specific for a container
@dataclass
class ContainerProperties:
    type: str

from typing import Any
from dataclasses import dataclass

# Struct specific properties
@dataclass
class StructProperties:
    properties: Properties
    required: List[str]

from typing import Any
from dataclasses import dataclass

# Map specific properties
@dataclass
class MapProperties:
    additional_properties: Union[BooleanType, NumberType, StringType, ArrayType, CombinationType, ReferenceType, GenericType]
    max_properties: int
    min_properties: int

from typing import Any
from dataclasses import dataclass

# Array properties
@dataclass
class ArrayProperties:
    type: str
    items: Union[BooleanType, NumberType, StringType, ReferenceType, GenericType]
    max_items: int
    min_items: int
    unique_items: bool

from typing import Any
from dataclasses import dataclass

# Boolean properties
@dataclass
class BooleanProperties:
    type: str

from typing import Any
from dataclasses import dataclass

# Number properties
@dataclass
class NumberProperties:
    type: str
    multiple_of: float
    maximum: float
    exclusive_maximum: bool
    minimum: float
    exclusive_minimum: bool

from typing import Any
from dataclasses import dataclass

# String properties
@dataclass
class StringProperties:
    type: str
    max_length: int
    min_length: int
    pattern: str

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
from typing import List

# An intersection type combines multiple schemas into one
@dataclass
class AllOfProperties:
    description: str
    all_of: List[OfValue]

from typing import Any
from dataclasses import dataclass
from typing import List

# An union type can contain one of the provided schemas
@dataclass
class OneOfProperties:
    description: str
    discriminator: Discriminator
    one_of: List[OfValue]

from typing import Any
from dataclasses import dataclass
from typing import Dict
class TemplateProperties(Dict[str, ReferenceType]):

from typing import Any
from dataclasses import dataclass

# Represents a reference to another schema
@dataclass
class ReferenceType:
    _ref: str
    _template: TemplateProperties

from typing import Any
from dataclasses import dataclass

# Represents a generic type
@dataclass
class GenericType:
    _generic: str

from typing import Any
from dataclasses import dataclass
from typing import Dict

# Schema definitions which can be reused
class Definitions(Dict[str, DefinitionValue]):

from typing import Any
from dataclasses import dataclass
from typing import Dict

# Contains external definitions which are imported. The imported schemas can be used via the namespace
class Import(Dict[str, str]):

from typing import Any
from dataclasses import dataclass

# TypeSchema meta schema which describes a TypeSchema
@dataclass
class TypeSchema:
    _import: Import
    title: str
    description: str
    type: str
    definitions: Definitions
    properties: Properties
    required: List[str]
