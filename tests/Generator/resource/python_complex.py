# Common properties which can be used at any schema
class CommonProperties:
    def __init__(self, title: str, description: str, type: str, nullable: bool, deprecated: bool, readonly: bool):
        self.title = title
        self.description = description
        self.type = type
        self.nullable = nullable
        self.deprecated = deprecated
        self.readonly = readonly

class ScalarProperties:
    def __init__(self, format: str, enum: , default: ):
        self.format = format
        self.enum = enum
        self.default = default

# Properties of a schema
class Properties(Mapping[str, PropertyValue]):

# Properties specific for a container
class ContainerProperties:
    def __init__(self, type: str):
        self.type = type

# Struct specific properties
class StructProperties:
    def __init__(self, properties: Properties, required: List[str]):
        self.properties = properties
        self.required = required

# Map specific properties
class MapProperties:
    def __init__(self, additionalProperties: , maxProperties: int, minProperties: int):
        self.additionalProperties = additionalProperties
        self.maxProperties = maxProperties
        self.minProperties = minProperties

# Array properties
class ArrayProperties:
    def __init__(self, type: str, items: , maxItems: int, minItems: int, uniqueItems: bool):
        self.type = type
        self.items = items
        self.maxItems = maxItems
        self.minItems = minItems
        self.uniqueItems = uniqueItems

# Boolean properties
class BooleanProperties:
    def __init__(self, type: str):
        self.type = type

# Number properties
class NumberProperties:
    def __init__(self, type: str, multipleOf: float, maximum: float, exclusiveMaximum: bool, minimum: float, exclusiveMinimum: bool):
        self.type = type
        self.multipleOf = multipleOf
        self.maximum = maximum
        self.exclusiveMaximum = exclusiveMaximum
        self.minimum = minimum
        self.exclusiveMinimum = exclusiveMinimum

# String properties
class StringProperties:
    def __init__(self, type: str, maxLength: int, minLength: int, pattern: str):
        self.type = type
        self.maxLength = maxLength
        self.minLength = minLength
        self.pattern = pattern

# An object to hold mappings between payload values and schema names or references
class DiscriminatorMapping(Mapping[str, str]):

# Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
class Discriminator:
    def __init__(self, propertyName: str, mapping: DiscriminatorMapping):
        self.propertyName = propertyName
        self.mapping = mapping

# An intersection type combines multiple schemas into one
class AllOfProperties:
    def __init__(self, description: str, allOf: List[OfValue]):
        self.description = description
        self.allOf = allOf

# An union type can contain one of the provided schemas
class OneOfProperties:
    def __init__(self, description: str, discriminator: Discriminator, oneOf: List[OfValue]):
        self.description = description
        self.discriminator = discriminator
        self.oneOf = oneOf

class TemplateProperties(Mapping[str, ReferenceType]):

# Represents a reference to another schema
class ReferenceType:
    def __init__(self, ref: str, template: TemplateProperties):
        self.ref = ref
        self.template = template

# Represents a generic type
class GenericType:
    def __init__(self, generic: str):
        self.generic = generic

# Schema definitions which can be reused
class Definitions(Mapping[str, DefinitionValue]):

# Contains external definitions which are imported. The imported schemas can be used via the namespace
class Import(Mapping[str, str]):

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
