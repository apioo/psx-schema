// Represents a base type. Every type extends from this common type and shares the defined properties
struct CommonType {
    description: String,
    _type: String,
    nullable: bool,
    deprecated: bool,
    readonly: bool,
}

// Represents a struct type. A struct type contains a fix set of defined properties
struct StructType {
    description: String,
    _type: String,
    nullable: bool,
    deprecated: bool,
    readonly: bool,
    _final: bool,
    extends: String,
    properties: Properties,
    required: Vec<String>,
}

// Properties of a struct
type Properties = HashMap<String, Object>() {
}

// Represents a map type. A map type contains variable key value entries of a specific type
struct MapType {
    description: String,
    _type: String,
    nullable: bool,
    deprecated: bool,
    readonly: bool,
    additionalProperties: Object,
    maxProperties: u64,
    minProperties: u64,
}

// Represents an array type. An array type contains an ordered list of a specific type
struct ArrayType {
    description: String,
    _type: String,
    nullable: bool,
    deprecated: bool,
    readonly: bool,
    items: Object,
    maxItems: u64,
    minItems: u64,
}

// Represents a scalar type
struct ScalarType {
    description: String,
    _type: String,
    nullable: bool,
    deprecated: bool,
    readonly: bool,
    format: String,
    _enum: Vec<Object>,
    default: Object,
}

// Represents a boolean type
struct BooleanType {
    description: String,
    _type: String,
    nullable: bool,
    deprecated: bool,
    readonly: bool,
    format: String,
    _enum: Vec<Object>,
    default: Object,
}

// Represents a number type (contains also integer)
struct NumberType {
    description: String,
    _type: String,
    nullable: bool,
    deprecated: bool,
    readonly: bool,
    format: String,
    _enum: Vec<Object>,
    default: Object,
    multipleOf: float64,
    maximum: float64,
    exclusiveMaximum: bool,
    minimum: float64,
    exclusiveMinimum: bool,
}

// Represents a string type
struct StringType {
    description: String,
    _type: String,
    nullable: bool,
    deprecated: bool,
    readonly: bool,
    format: String,
    _enum: Vec<Object>,
    default: Object,
    maxLength: u64,
    minLength: u64,
    pattern: String,
}

// Represents an any type
struct AnyType {
    description: String,
    _type: String,
    nullable: bool,
    deprecated: bool,
    readonly: bool,
}

// Represents an intersection type
struct IntersectionType {
    description: String,
    allOf: Vec<ReferenceType>,
}

// Represents an union type. An union type can contain one of the provided types
struct UnionType {
    description: String,
    discriminator: Discriminator,
    oneOf: Vec<Object>,
}

// An object to hold mappings between payload values and schema names or references
type DiscriminatorMapping = HashMap<String, String>() {
}

// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
struct Discriminator {
    propertyName: String,
    mapping: DiscriminatorMapping,
}

// Represents a reference type. A reference type points to a specific type at the definitions map
struct ReferenceType {
    _ref: String,
    template: TemplateProperties,
}

type TemplateProperties = HashMap<String, String>() {
}

// Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
struct GenericType {
    generic: String,
}

// The definitions map which contains all types
type Definitions = HashMap<String, Object>() {
}

// Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. 'my_namespace:my_type'
type Import = HashMap<String, String>() {
}

// The root TypeSchema
struct TypeSchema {
    import: Import,
    definitions: Definitions,
    _ref: String,
}
