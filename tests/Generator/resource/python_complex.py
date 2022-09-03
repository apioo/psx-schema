from typing import Any

# Common properties which can be used at any schema
class CommonProperties:
    def __init__(self, title: str, description: str, type: str, nullable: bool, deprecated: bool, readonly: bool):
        self.title = title
        self.description = description
        self.type = type
        self.nullable = nullable
        self.deprecated = deprecated
        self.readonly = readonly

from typing import Any
class ScalarProperties:
    def __init__(self, format: str, enum: Union[StringArray, NumberArray], default: Union[str, float, bool]):
        self.format = format
        self.enum = enum
        self.default = default

from typing import Any
from typing import Dict

# Properties of a schema
class Properties(Dict[str, PropertyValue]):

from typing import Any

# Properties specific for a container
class ContainerProperties:
    def __init__(self, type: str):
        self.type = type

from typing import Any

# Struct specific properties
class StructProperties:
    def __init__(self, properties: Properties, required: List[str]):
        self.properties = properties
        self.required = required

from typing import Any

# Map specific properties
class MapProperties:
    def __init__(self, additional_properties: Union[BooleanType, NumberType, StringType, ArrayType, CombinationType, ReferenceType, GenericType], max_properties: int, min_properties: int):
        self.additional_properties = additional_properties
        self.max_properties = max_properties
        self.min_properties = min_properties

from typing import Any

# Array properties
class ArrayProperties:
    def __init__(self, type: str, items: Union[BooleanType, NumberType, StringType, ReferenceType, GenericType], max_items: int, min_items: int, unique_items: bool):
        self.type = type
        self.items = items
        self.max_items = max_items
        self.min_items = min_items
        self.unique_items = unique_items

from typing import Any

# Boolean properties
class BooleanProperties:
    def __init__(self, type: str):
        self.type = type

from typing import Any

# Number properties
class NumberProperties:
    def __init__(self, type: str, multiple_of: float, maximum: float, exclusive_maximum: bool, minimum: float, exclusive_minimum: bool):
        self.type = type
        self.multiple_of = multiple_of
        self.maximum = maximum
        self.exclusive_maximum = exclusive_maximum
        self.minimum = minimum
        self.exclusive_minimum = exclusive_minimum

from typing import Any

# String properties
class StringProperties:
    def __init__(self, type: str, max_length: int, min_length: int, pattern: str):
        self.type = type
        self.max_length = max_length
        self.min_length = min_length
        self.pattern = pattern

from typing import Any
from typing import Dict

# An object to hold mappings between payload values and schema names or references
class DiscriminatorMapping(Dict[str, str]):

from typing import Any

# Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
class Discriminator:
    def __init__(self, property_name: str, mapping: DiscriminatorMapping):
        self.property_name = property_name
        self.mapping = mapping

from typing import Any
from typing import List

# An intersection type combines multiple schemas into one
class AllOfProperties:
    def __init__(self, description: str, all_of: List[OfValue]):
        self.description = description
        self.all_of = all_of

from typing import Any
from typing import List

# An union type can contain one of the provided schemas
class OneOfProperties:
    def __init__(self, description: str, discriminator: Discriminator, one_of: List[OfValue]):
        self.description = description
        self.discriminator = discriminator
        self.one_of = one_of

from typing import Any
from typing import Dict
class TemplateProperties(Dict[str, ReferenceType]):

from typing import Any

# Represents a reference to another schema
class ReferenceType:
    def __init__(self, _ref: str, _template: TemplateProperties):
        self._ref = _ref
        self._template = _template

from typing import Any

# Represents a generic type
class GenericType:
    def __init__(self, _generic: str):
        self._generic = _generic

from typing import Any
from typing import Dict

# Schema definitions which can be reused
class Definitions(Dict[str, DefinitionValue]):

from typing import Any
from typing import Dict

# Contains external definitions which are imported. The imported schemas can be used via the namespace
class Import(Dict[str, str]):

from typing import Any

# TypeSchema meta schema which describes a TypeSchema
class TypeSchema:
    def __init__(self, _import: Import, title: str, description: str, type: str, definitions: Definitions, properties: Properties, required: List[str]):
        self._import = _import
        self.title = title
        self.description = description
        self.type = type
        self.definitions = definitions
        self.properties = properties
        self.required = required
