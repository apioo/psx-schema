// Common properties which can be used at any schema
class CommonProperties: Codable {
    var title: String
    var description: String
    var type: String
    var nullable: Bool
    var deprecated: Bool
    var readonly: Bool
}

class ScalarProperties: Codable {
    var format: String
    var enum: EnumValue
    var default: ScalarValue
}

typealias PropertyValue = BooleanType | NumberType | StringType | ArrayType | CombinationType | ReferenceType | GenericType;

typealias Properties = Dictionary<String, PropertyValue>;

// Properties specific for a container
class ContainerProperties: Codable {
    var type: String
}

// Struct specific properties
class StructProperties: Codable {
    var properties: Properties
    var required: StringArray
}

typealias StructType = CommonProperties & ContainerProperties & StructProperties;

// Map specific properties
class MapProperties: Codable {
    var additionalProperties: PropertyValue
    var maxProperties: Int
    var minProperties: Int
}

typealias MapType = CommonProperties & ContainerProperties & MapProperties;

typealias ObjectType = StructType | MapType;

typealias ArrayValue = BooleanType | NumberType | StringType | ReferenceType | GenericType;

// Array properties
class ArrayProperties: Codable {
    var type: String
    var items: ArrayValue
    var maxItems: Int
    var minItems: Int
    var uniqueItems: Bool
}

typealias ArrayType = CommonProperties & ArrayProperties;

// Boolean properties
class BooleanProperties: Codable {
    var type: String
}

typealias BooleanType = CommonProperties & ScalarProperties & BooleanProperties;

// Number properties
class NumberProperties: Codable {
    var type: String
    var multipleOf: Float
    var maximum: Float
    var exclusiveMaximum: Bool
    var minimum: Float
    var exclusiveMinimum: Bool
}

typealias NumberType = CommonProperties & ScalarProperties & NumberProperties;

// String properties
class StringProperties: Codable {
    var type: String
    var maxLength: Int
    var minLength: Int
    var pattern: String
}

typealias StringType = CommonProperties & ScalarProperties & StringProperties;

typealias OfValue = NumberType | StringType | BooleanType | ReferenceType;

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

typealias DefinitionValue = ObjectType | ArrayType | BooleanType | NumberType | StringType | CombinationType;

typealias Definitions = Dictionary<String, DefinitionValue>;

typealias Import = Dictionary<String, String>;

typealias EnumValue = StringArray | NumberArray;

typealias ScalarValue = String | Float | Bool;

typealias StringArray = Array<String>;

typealias NumberArray = Array<Float>;

// TypeSchema meta schema which describes a TypeSchema
class TypeSchema: Codable {
    var import: Import
    var title: String
    var description: String
    var type: String
    var definitions: Definitions
    var properties: Properties
    var required: StringArray
}
