// Represents a base type. Every type extends from this common type and shares the defined properties
class CommonType: Codable {
    var description: String
    var _type: String
    var nullable: Bool
    var deprecated: Bool
    var readonly: Bool

    enum CodingKeys: String, CodingKey {
        case description = "description"
        case _type = "type"
        case nullable = "nullable"
        case deprecated = "deprecated"
        case readonly = "readonly"
    }
}

// Represents an any type
class AnyType: CommonType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

// Represents an array type. An array type contains an ordered list of a specific type
class ArrayType: CommonType {
    var _type: String
    var items: BooleanType | NumberType | StringType | ReferenceType | GenericType | AnyType
    var maxItems: Int
    var minItems: Int

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case items = "items"
        case maxItems = "maxItems"
        case minItems = "minItems"
    }
}

// Represents a scalar type
class ScalarType: CommonType {
    var format: String
    var _enum: Array<String | Float>
    var _default: String | Float | Bool

    enum CodingKeys: String, CodingKey {
        case format = "format"
        case _enum = "enum"
        case _default = "default"
    }
}

// Represents a boolean type
class BooleanType: ScalarType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
class Discriminator: Codable {
    var propertyName: String
    var mapping: Dictionary<String, String>

    enum CodingKeys: String, CodingKey {
        case propertyName = "propertyName"
        case mapping = "mapping"
    }
}

// Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
class GenericType: Codable {
    var generic: String

    enum CodingKeys: String, CodingKey {
        case generic = "$generic"
    }
}

// Represents an intersection type
class IntersectionType: Codable {
    var description: String
    var allOf: Array<ReferenceType>

    enum CodingKeys: String, CodingKey {
        case description = "description"
        case allOf = "allOf"
    }
}

// Represents a map type. A map type contains variable key value entries of a specific type
class MapType: CommonType {
    var _type: String
    var additionalProperties: BooleanType | NumberType | StringType | ArrayType | UnionType | IntersectionType | ReferenceType | GenericType | AnyType
    var maxProperties: Int
    var minProperties: Int

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case additionalProperties = "additionalProperties"
        case maxProperties = "maxProperties"
        case minProperties = "minProperties"
    }
}

// Represents a number type (contains also integer)
class NumberType: ScalarType {
    var _type: String
    var multipleOf: Float
    var maximum: Float
    var exclusiveMaximum: Bool
    var minimum: Float
    var exclusiveMinimum: Bool

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case multipleOf = "multipleOf"
        case maximum = "maximum"
        case exclusiveMaximum = "exclusiveMaximum"
        case minimum = "minimum"
        case exclusiveMinimum = "exclusiveMinimum"
    }
}

// Represents a reference type. A reference type points to a specific type at the definitions map
class ReferenceType: Codable {
    var ref: String
    var template: Dictionary<String, String>

    enum CodingKeys: String, CodingKey {
        case ref = "$ref"
        case template = "$template"
    }
}

// Represents a string type
class StringType: ScalarType {
    var _type: String
    var maxLength: Int
    var minLength: Int
    var pattern: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case maxLength = "maxLength"
        case minLength = "minLength"
        case pattern = "pattern"
    }
}

// Represents a struct type. A struct type contains a fix set of defined properties
class StructType: CommonType {
    var _final: Bool
    var extends: String
    var _type: String
    var properties: Dictionary<String, MapType | ArrayType | BooleanType | NumberType | StringType | AnyType | IntersectionType | UnionType | ReferenceType | GenericType>
    var _required: Array<String>

    enum CodingKeys: String, CodingKey {
        case _final = "$final"
        case extends = "$extends"
        case _type = "type"
        case properties = "properties"
        case _required = "required"
    }
}

// The root TypeSchema
class TypeSchema: Codable {
    var _import: Dictionary<String, String>
    var definitions: Dictionary<String, StructType | MapType | ReferenceType>
    var ref: String

    enum CodingKeys: String, CodingKey {
        case _import = "$import"
        case definitions = "definitions"
        case ref = "$ref"
    }
}

// Represents an union type. An union type can contain one of the provided types
class UnionType: Codable {
    var description: String
    var discriminator: Discriminator
    var oneOf: Array<NumberType | StringType | BooleanType | ReferenceType>

    enum CodingKeys: String, CodingKey {
        case description = "description"
        case discriminator = "discriminator"
        case oneOf = "oneOf"
    }
}
