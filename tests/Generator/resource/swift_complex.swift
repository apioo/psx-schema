// Represents a base type. Every type extends from this common type and shares the defined properties
class CommonType: Codable {
    var description: String
    var _type: String
    var nullable: Bool
    var deprecated: Bool
    var readonly: Bool
}

// Represents a struct type. A struct type contains a fix set of defined properties
class StructType: CommonType {
    var _final: Bool
    var extends: String
    var _type: String
    var properties: Properties
    var _required: Array<String>
}

// Properties of a struct
typealias Properties = Dictionary<String, BooleanType | NumberType | StringType | ArrayType | UnionType | IntersectionType | ReferenceType | GenericType | AnyType>;

// Represents a map type. A map type contains variable key value entries of a specific type
class MapType: CommonType {
    var _type: String
    var additionalProperties: BooleanType | NumberType | StringType | ArrayType | UnionType | IntersectionType | ReferenceType | GenericType | AnyType
    var maxProperties: Int
    var minProperties: Int
}

// Represents an array type. An array type contains an ordered list of a specific type
class ArrayType: CommonType {
    var _type: String
    var items: BooleanType | NumberType | StringType | ReferenceType | GenericType | AnyType
    var maxItems: Int
    var minItems: Int
}

// Represents a scalar type
class ScalarType: CommonType {
    var format: String
    var _enum: Array<String | Float>
    var _default: String | Float | Bool
}

// Represents a boolean type
class BooleanType: ScalarType {
    var _type: String
}

// Represents a number type (contains also integer)
class NumberType: ScalarType {
    var _type: String
    var multipleOf: Float
    var maximum: Float
    var exclusiveMaximum: Bool
    var minimum: Float
    var exclusiveMinimum: Bool
}

// Represents a string type
class StringType: ScalarType {
    var _type: String
    var maxLength: Int
    var minLength: Int
    var pattern: String
}

// Represents an any type
class AnyType: CommonType {
    var _type: String
}

// Represents an intersection type
class IntersectionType: Codable {
    var description: String
    var allOf: Array<ReferenceType>
}

// Represents an union type. An union type can contain one of the provided types
class UnionType: Codable {
    var description: String
    var discriminator: Discriminator
    var oneOf: Array<NumberType | StringType | BooleanType | ReferenceType>
}

// An object to hold mappings between payload values and schema names or references
typealias DiscriminatorMapping = Dictionary<String, String>;

// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
class Discriminator: Codable {
    var propertyName: String
    var mapping: DiscriminatorMapping
}

// Represents a reference type. A reference type points to a specific type at the definitions map
class ReferenceType: Codable {
    var ref: String
    var template: TemplateProperties
}

typealias TemplateProperties = Dictionary<String, String>;

// Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
class GenericType: Codable {
    var generic: String
}

// The definitions map which contains all types
typealias Definitions = Dictionary<String, StructType | MapType | ReferenceType>;

// Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. 'my_namespace:my_type'
typealias Import = Dictionary<String, String>;

// The root TypeSchema
class TypeSchema: Codable {
    var _import: Import
    var definitions: Definitions
    var ref: String
}
