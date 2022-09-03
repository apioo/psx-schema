// Common properties which can be used at any schema
class CommonProperties: Codable {
    var title: String
    var description: String
    var _type: String
    var nullable: Bool
    var deprecated: Bool
    var readonly: Bool
}

class ScalarProperties: Codable {
    var format: String
    var _enum: EnumValue
    var _default: ScalarValue
}

// Allowed values of an object property
typealias PropertyValue = BooleanType | NumberType | StringType | ArrayType | CombinationType | ReferenceType | GenericType;

// Properties of a schema
typealias Properties = Dictionary<String, PropertyValue>;

// Properties specific for a container
class ContainerProperties: Codable {
    var _type: String
}

// Struct specific properties
class StructProperties: Codable {
    var properties: Properties
    var _required: StringArray
}

// A struct contains a fix set of defined properties
typealias StructType = CommonProperties & ContainerProperties & StructProperties;

// Map specific properties
class MapProperties: Codable {
    var additionalProperties: PropertyValue
    var maxProperties: Int
    var minProperties: Int
}

// A map contains variable key value entries of a specific type
typealias MapType = CommonProperties & ContainerProperties & MapProperties;

// An object represents either a struct or map type
typealias ObjectType = StructType | MapType;

// Allowed values of an array item
typealias ArrayValue = BooleanType | NumberType | StringType | ReferenceType | GenericType;

// Array properties
class ArrayProperties: Codable {
    var _type: String
    var items: ArrayValue
    var maxItems: Int
    var minItems: Int
    var uniqueItems: Bool
}

// An array contains an ordered list of a specific type
typealias ArrayType = CommonProperties & ArrayProperties;

// Boolean properties
class BooleanProperties: Codable {
    var _type: String
}

// Represents a boolean value
typealias BooleanType = CommonProperties & ScalarProperties & BooleanProperties;

// Number properties
class NumberProperties: Codable {
    var _type: String
    var multipleOf: Float
    var maximum: Float
    var exclusiveMaximum: Bool
    var minimum: Float
    var exclusiveMinimum: Bool
}

// Represents a number value (contains also integer)
typealias NumberType = CommonProperties & ScalarProperties & NumberProperties;

// String properties
class StringProperties: Codable {
    var _type: String
    var maxLength: Int
    var minLength: Int
    var pattern: String
}

// Represents a string value
typealias StringType = CommonProperties & ScalarProperties & StringProperties;

// Allowed values in a combination schema
typealias OfValue = NumberType | StringType | BooleanType | ReferenceType;

// An object to hold mappings between payload values and schema names or references
typealias DiscriminatorMapping = Dictionary<String, String>;

// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
class Discriminator: Codable {
    var propertyName: String
    var mapping: DiscriminatorMapping
}

// An intersection type combines multiple schemas into one
class AllOfProperties: Codable {
    var description: String
    var allOf: Array<OfValue>
}

// An union type can contain one of the provided schemas
class OneOfProperties: Codable {
    var description: String
    var discriminator: Discriminator
    var oneOf: Array<OfValue>
}

// A combination type is either a intersection or union type
typealias CombinationType = AllOfProperties | OneOfProperties;

typealias TemplateProperties = Dictionary<String, ReferenceType>;

// Represents a reference to another schema
class ReferenceType: Codable {
    var ref: String
    var template: TemplateProperties
}

// Represents a generic type
class GenericType: Codable {
    var generic: String
}

// Represents a concrete type definition
typealias DefinitionValue = ObjectType | ArrayType | BooleanType | NumberType | StringType | CombinationType;

// Schema definitions which can be reused
typealias Definitions = Dictionary<String, DefinitionValue>;

// Contains external definitions which are imported. The imported schemas can be used via the namespace
typealias Import = Dictionary<String, String>;

// A list of possible enumeration values
typealias EnumValue = StringArray | NumberArray;

// Represents a scalar value
typealias ScalarValue = String | Float | Bool;

// Array string values
typealias StringArray = Array<String>;

// Array number values
typealias NumberArray = Array<Float>;

// TypeSchema meta schema which describes a TypeSchema
class TypeSchema: Codable {
    var _import: Import
    var title: String
    var description: String
    var _type: String
    var definitions: Definitions
    var properties: Properties
    var _required: StringArray
}
