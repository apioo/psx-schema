use serde::{Deserialize, Serialize};

// Represents a base type. Every type extends from this common type and shares the defined properties
#[derive(Serialize, Deserialize)]
struct CommonType {
    description: String,
    _type: String,
    nullable: bool,
    deprecated: bool,
    readonly: bool,
}

use serde::{Deserialize, Serialize};

// Represents a struct type. A struct type contains a fix set of defined properties
#[derive(Serialize, Deserialize)]
struct StructType {
    *CommonType
    _final: bool,
    extends: String,
    _type: String,
    properties: Properties,
    required: Vec<String>,
}

use serde::{Deserialize, Serialize};

// Properties of a struct
type Properties = HashMap<String, Object>() {
}

use serde::{Deserialize, Serialize};

// Represents a map type. A map type contains variable key value entries of a specific type
#[derive(Serialize, Deserialize)]
struct MapType {
    *CommonType
    _type: String,
    additionalProperties: Object,
    maxProperties: u64,
    minProperties: u64,
}

use serde::{Deserialize, Serialize};

// Represents an array type. An array type contains an ordered list of a specific type
#[derive(Serialize, Deserialize)]
struct ArrayType {
    *CommonType
    _type: String,
    items: Object,
    maxItems: u64,
    minItems: u64,
}

use serde::{Deserialize, Serialize};

// Represents a scalar type
#[derive(Serialize, Deserialize)]
struct ScalarType {
    *CommonType
    format: String,
    _enum: Vec<Object>,
    default: Object,
}

use serde::{Deserialize, Serialize};

// Represents a boolean type
#[derive(Serialize, Deserialize)]
struct BooleanType {
    *ScalarType
    _type: String,
}

use serde::{Deserialize, Serialize};

// Represents a number type (contains also integer)
#[derive(Serialize, Deserialize)]
struct NumberType {
    *ScalarType
    _type: String,
    multipleOf: float64,
    maximum: float64,
    exclusiveMaximum: bool,
    minimum: float64,
    exclusiveMinimum: bool,
}

use serde::{Deserialize, Serialize};

// Represents a string type
#[derive(Serialize, Deserialize)]
struct StringType {
    *ScalarType
    _type: String,
    maxLength: u64,
    minLength: u64,
    pattern: String,
}

use serde::{Deserialize, Serialize};

// Represents an any type
#[derive(Serialize, Deserialize)]
struct AnyType {
    *CommonType
    _type: String,
}

use serde::{Deserialize, Serialize};

// Represents an intersection type
#[derive(Serialize, Deserialize)]
struct IntersectionType {
    description: String,
    allOf: Vec<ReferenceType>,
}

use serde::{Deserialize, Serialize};

// Represents an union type. An union type can contain one of the provided types
#[derive(Serialize, Deserialize)]
struct UnionType {
    description: String,
    discriminator: Discriminator,
    oneOf: Vec<Object>,
}

use serde::{Deserialize, Serialize};

// An object to hold mappings between payload values and schema names or references
type DiscriminatorMapping = HashMap<String, String>() {
}

use serde::{Deserialize, Serialize};

// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
#[derive(Serialize, Deserialize)]
struct Discriminator {
    propertyName: String,
    mapping: DiscriminatorMapping,
}

use serde::{Deserialize, Serialize};

// Represents a reference type. A reference type points to a specific type at the definitions map
#[derive(Serialize, Deserialize)]
struct ReferenceType {
    _ref: String,
    template: TemplateProperties,
}

use serde::{Deserialize, Serialize};
type TemplateProperties = HashMap<String, String>() {
}

use serde::{Deserialize, Serialize};

// Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
#[derive(Serialize, Deserialize)]
struct GenericType {
    generic: String,
}

use serde::{Deserialize, Serialize};

// The definitions map which contains all types
type Definitions = HashMap<String, Object>() {
}

use serde::{Deserialize, Serialize};

// Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. 'my_namespace:my_type'
type Import = HashMap<String, String>() {
}

use serde::{Deserialize, Serialize};

// The root TypeSchema
#[derive(Serialize, Deserialize)]
struct TypeSchema {
    import: Import,
    definitions: Definitions,
    _ref: String,
}
