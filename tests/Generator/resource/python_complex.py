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
    def __init__(self, additionalProperties: Union[BooleanType, NumberType, StringType, ArrayType, CombinationType, ReferenceType, GenericType], maxProperties: int, minProperties: int):
        self.additionalProperties = additionalProperties
        self.maxProperties = maxProperties
        self.minProperties = minProperties

from typing import Any

# Array properties
class ArrayProperties:
    def __init__(self, type: str, items: Union[BooleanType, NumberType, StringType, ReferenceType, GenericType], maxItems: int, minItems: int, uniqueItems: bool):
        self.type = type
        self.items = items
        self.maxItems = maxItems
        self.minItems = minItems
        self.uniqueItems = uniqueItems

from typing import Any

# Boolean properties
class BooleanProperties:
    def __init__(self, type: str):
        self.type = type

from typing import Any

# Number properties
class NumberProperties:
    def __init__(self, type: str, multipleOf: float, maximum: float, exclusiveMaximum: bool, minimum: float, exclusiveMinimum: bool):
        self.type = type
        self.multipleOf = multipleOf
        self.maximum = maximum
        self.exclusiveMaximum = exclusiveMaximum
        self.minimum = minimum
        self.exclusiveMinimum = exclusiveMinimum

from typing import Any

# String properties
class StringProperties:
    def __init__(self, type: str, maxLength: int, minLength: int, pattern: str):
        self.type = type
        self.maxLength = maxLength
        self.minLength = minLength
        self.pattern = pattern

from typing import Any
from typing import Dict

# An object to hold mappings between payload values and schema names or references
class DiscriminatorMapping(Dict[str, str]):

from typing import Any

# Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
class Discriminator:
    def __init__(self, propertyName: str, mapping: DiscriminatorMapping):
        self.propertyName = propertyName
        self.mapping = mapping

from typing import Any
from typing import List

# An intersection type combines multiple schemas into one
class AllOfProperties:
    def __init__(self, description: str, allOf: List[OfValue]):
        self.description = description
        self.allOf = allOf

from typing import Any
from typing import List

# An union type can contain one of the provided schemas
class OneOfProperties:
    def __init__(self, description: str, discriminator: Discriminator, oneOf: List[OfValue]):
        self.description = description
        self.discriminator = discriminator
        self.oneOf = oneOf

from typing import Any
from typing import Dict
class TemplateProperties(Dict[str, ReferenceType]):

from typing import Any

# Represents a reference to another schema
class ReferenceType:
    def __init__(self, ref: str, template: TemplateProperties):
        self.ref = ref
        self.template = template

from typing import Any

# Represents a generic type
class GenericType:
    def __init__(self, generic: str):
        self.generic = generic

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
    def __init__(self, import: Import, title: str, description: str, type: str, definitions: Definitions, properties: Properties, required: List[str]):
        self.import = import
        self.title = title
        self.description = description
        self.type = type
        self.definitions = definitions
        self.properties = properties
        self.required = required
