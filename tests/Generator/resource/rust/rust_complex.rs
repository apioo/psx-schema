use serde::{Serialize, Deserialize};

// Represents a base type. Every type extends from this common type and shares the defined properties
#[derive(Serialize, Deserialize)]
struct CommonType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "type")]
    _type: String,
    #[serde(rename = "nullable")]
    nullable: bool,
    #[serde(rename = "deprecated")]
    deprecated: bool,
    #[serde(rename = "readonly")]
    readonly: bool,
}

use serde::{Serialize, Deserialize};

// Represents a struct type. A struct type contains a fix set of defined properties
#[derive(Serialize, Deserialize)]
struct StructType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "type")]
    _type: String,
    #[serde(rename = "nullable")]
    nullable: bool,
    #[serde(rename = "deprecated")]
    deprecated: bool,
    #[serde(rename = "readonly")]
    readonly: bool,
    #[serde(rename = "$final")]
    _final: bool,
    #[serde(rename = "$extends")]
    extends: String,
    #[serde(rename = "properties")]
    properties: Properties,
    #[serde(rename = "required")]
    required: Vec<String>,
}

// Properties of a struct
type Properties = HashMap<String, Object>() {
}

use serde::{Serialize, Deserialize};

// Represents a map type. A map type contains variable key value entries of a specific type
#[derive(Serialize, Deserialize)]
struct MapType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "type")]
    _type: String,
    #[serde(rename = "nullable")]
    nullable: bool,
    #[serde(rename = "deprecated")]
    deprecated: bool,
    #[serde(rename = "readonly")]
    readonly: bool,
    #[serde(rename = "additionalProperties")]
    additionalProperties: Object,
    #[serde(rename = "maxProperties")]
    maxProperties: u64,
    #[serde(rename = "minProperties")]
    minProperties: u64,
}

use serde::{Serialize, Deserialize};

// Represents an array type. An array type contains an ordered list of a specific type
#[derive(Serialize, Deserialize)]
struct ArrayType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "type")]
    _type: String,
    #[serde(rename = "nullable")]
    nullable: bool,
    #[serde(rename = "deprecated")]
    deprecated: bool,
    #[serde(rename = "readonly")]
    readonly: bool,
    #[serde(rename = "items")]
    items: Object,
    #[serde(rename = "maxItems")]
    maxItems: u64,
    #[serde(rename = "minItems")]
    minItems: u64,
}

use serde::{Serialize, Deserialize};

// Represents a scalar type
#[derive(Serialize, Deserialize)]
struct ScalarType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "type")]
    _type: String,
    #[serde(rename = "nullable")]
    nullable: bool,
    #[serde(rename = "deprecated")]
    deprecated: bool,
    #[serde(rename = "readonly")]
    readonly: bool,
    #[serde(rename = "format")]
    format: String,
    #[serde(rename = "enum")]
    _enum: Vec<Object>,
    #[serde(rename = "default")]
    default: Object,
}

use serde::{Serialize, Deserialize};

// Represents a boolean type
#[derive(Serialize, Deserialize)]
struct BooleanType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "type")]
    _type: String,
    #[serde(rename = "nullable")]
    nullable: bool,
    #[serde(rename = "deprecated")]
    deprecated: bool,
    #[serde(rename = "readonly")]
    readonly: bool,
    #[serde(rename = "format")]
    format: String,
    #[serde(rename = "enum")]
    _enum: Vec<Object>,
    #[serde(rename = "default")]
    default: Object,
}

use serde::{Serialize, Deserialize};

// Represents a number type (contains also integer)
#[derive(Serialize, Deserialize)]
struct NumberType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "type")]
    _type: String,
    #[serde(rename = "nullable")]
    nullable: bool,
    #[serde(rename = "deprecated")]
    deprecated: bool,
    #[serde(rename = "readonly")]
    readonly: bool,
    #[serde(rename = "format")]
    format: String,
    #[serde(rename = "enum")]
    _enum: Vec<Object>,
    #[serde(rename = "default")]
    default: Object,
    #[serde(rename = "multipleOf")]
    multipleOf: float64,
    #[serde(rename = "maximum")]
    maximum: float64,
    #[serde(rename = "exclusiveMaximum")]
    exclusiveMaximum: bool,
    #[serde(rename = "minimum")]
    minimum: float64,
    #[serde(rename = "exclusiveMinimum")]
    exclusiveMinimum: bool,
}

use serde::{Serialize, Deserialize};

// Represents a string type
#[derive(Serialize, Deserialize)]
struct StringType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "type")]
    _type: String,
    #[serde(rename = "nullable")]
    nullable: bool,
    #[serde(rename = "deprecated")]
    deprecated: bool,
    #[serde(rename = "readonly")]
    readonly: bool,
    #[serde(rename = "format")]
    format: String,
    #[serde(rename = "enum")]
    _enum: Vec<Object>,
    #[serde(rename = "default")]
    default: Object,
    #[serde(rename = "maxLength")]
    maxLength: u64,
    #[serde(rename = "minLength")]
    minLength: u64,
    #[serde(rename = "pattern")]
    pattern: String,
}

use serde::{Serialize, Deserialize};

// Represents an any type
#[derive(Serialize, Deserialize)]
struct AnyType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "type")]
    _type: String,
    #[serde(rename = "nullable")]
    nullable: bool,
    #[serde(rename = "deprecated")]
    deprecated: bool,
    #[serde(rename = "readonly")]
    readonly: bool,
}

use serde::{Serialize, Deserialize};

// Represents an intersection type
#[derive(Serialize, Deserialize)]
struct IntersectionType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "allOf")]
    allOf: Vec<ReferenceType>,
}

use serde::{Serialize, Deserialize};

// Represents an union type. An union type can contain one of the provided types
#[derive(Serialize, Deserialize)]
struct UnionType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "discriminator")]
    discriminator: Discriminator,
    #[serde(rename = "oneOf")]
    oneOf: Vec<Object>,
}

// An object to hold mappings between payload values and schema names or references
type DiscriminatorMapping = HashMap<String, String>() {
}

use serde::{Serialize, Deserialize};

// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
#[derive(Serialize, Deserialize)]
struct Discriminator {
    #[serde(rename = "propertyName")]
    propertyName: String,
    #[serde(rename = "mapping")]
    mapping: DiscriminatorMapping,
}

use serde::{Serialize, Deserialize};

// Represents a reference type. A reference type points to a specific type at the definitions map
#[derive(Serialize, Deserialize)]
struct ReferenceType {
    #[serde(rename = "$ref")]
    _ref: String,
    #[serde(rename = "$template")]
    template: TemplateProperties,
}

type TemplateProperties = HashMap<String, String>() {
}

use serde::{Serialize, Deserialize};

// Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
#[derive(Serialize, Deserialize)]
struct GenericType {
    #[serde(rename = "$generic")]
    generic: String,
}

// The definitions map which contains all types
type Definitions = HashMap<String, Object>() {
}

// Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. 'my_namespace:my_type'
type Import = HashMap<String, String>() {
}

use serde::{Serialize, Deserialize};

// The root TypeSchema
#[derive(Serialize, Deserialize)]
struct TypeSchema {
    #[serde(rename = "$import")]
    import: Import,
    #[serde(rename = "definitions")]
    definitions: Definitions,
    #[serde(rename = "$ref")]
    _ref: String,
}
