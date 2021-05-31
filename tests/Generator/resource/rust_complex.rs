// Common properties which can be used at any schema
struct CommonProperties {
    title: String,
    description: String,
    type: String,
    nullable: bool,
    deprecated: bool,
    readonly: bool,
}

struct ScalarProperties {
    format: String,
    enum: Object,
    default: Object,
}

// Properties of a schema
type Properties = HashMap<String, PropertyValue>() {
}

// Properties specific for a container
struct ContainerProperties {
    type: String,
}

// Struct specific properties
struct StructProperties {
    properties: Properties,
    required: Vec<String>,
}

// Map specific properties
struct MapProperties {
    additionalProperties: Object,
    maxProperties: u64,
    minProperties: u64,
}

// Array properties
struct ArrayProperties {
    type: String,
    items: Object,
    maxItems: u64,
    minItems: u64,
    uniqueItems: bool,
}

// Boolean properties
struct BooleanProperties {
    type: String,
}

// Number properties
struct NumberProperties {
    type: String,
    multipleOf: float64,
    maximum: float64,
    exclusiveMaximum: bool,
    minimum: float64,
    exclusiveMinimum: bool,
}

// String properties
struct StringProperties {
    type: String,
    maxLength: u64,
    minLength: u64,
    pattern: String,
}

// An object to hold mappings between payload values and schema names or references
type DiscriminatorMapping = HashMap<String, String>() {
}

// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
struct Discriminator {
    propertyName: String,
    mapping: DiscriminatorMapping,
}

// An intersection type combines multiple schemas into one
struct AllOfProperties {
    description: String,
    allOf: Vec<OfValue>,
}

// An union type can contain one of the provided schemas
struct OneOfProperties {
    description: String,
    discriminator: Discriminator,
    oneOf: Vec<OfValue>,
}

type TemplateProperties = HashMap<String, ReferenceType>() {
}

// Represents a reference to another schema
struct ReferenceType {
    ref: String,
    template: TemplateProperties,
}

// Represents a generic type
struct GenericType {
    generic: String,
}

// Schema definitions which can be reused
type Definitions = HashMap<String, DefinitionValue>() {
}

// Contains external definitions which are imported. The imported schemas can be used via the namespace
type Import = HashMap<String, String>() {
}

// TypeSchema meta schema which describes a TypeSchema
struct TypeSchema {
    import: Import,
    title: String,
    description: String,
    type: String,
    definitions: Definitions,
    properties: Properties,
    required: Vec<String>,
}
