use serde::{Serialize, Deserialize};

// Represents a base type. Every type extends from this common type and shares the defined properties
#[derive(Serialize, Deserialize)]
pub struct CommonType {
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
use common_type::CommonType;
use properties::Properties;

// Represents a struct type. A struct type contains a fix set of defined properties
#[derive(Serialize, Deserialize)]
pub struct StructType {
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
    _extends: String,
    #[serde(rename = "properties")]
    properties: Properties,
    #[serde(rename = "required")]
    required: Vec<String>,
}

use std::collections::HashMap;
use boolean_type::BooleanType;
use number_type::NumberType;
use string_type::StringType;
use array_type::ArrayType;
use union_type::UnionType;
use intersection_type::IntersectionType;
use reference_type::ReferenceType;
use generic_type::GenericType;
use any_type::AnyType;

// Properties of a struct
pub type Properties = HashMap<String, serde_json::Value>;

use serde::{Serialize, Deserialize};
use common_type::CommonType;
use boolean_type::BooleanType;
use number_type::NumberType;
use string_type::StringType;
use array_type::ArrayType;
use union_type::UnionType;
use intersection_type::IntersectionType;
use reference_type::ReferenceType;
use generic_type::GenericType;
use any_type::AnyType;

// Represents a map type. A map type contains variable key value entries of a specific type
#[derive(Serialize, Deserialize)]
pub struct MapType {
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
    additional_properties: serde_json::Value,
    #[serde(rename = "maxProperties")]
    max_properties: u64,
    #[serde(rename = "minProperties")]
    min_properties: u64,
}

use serde::{Serialize, Deserialize};
use common_type::CommonType;
use boolean_type::BooleanType;
use number_type::NumberType;
use string_type::StringType;
use reference_type::ReferenceType;
use generic_type::GenericType;
use any_type::AnyType;

// Represents an array type. An array type contains an ordered list of a specific type
#[derive(Serialize, Deserialize)]
pub struct ArrayType {
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
    items: serde_json::Value,
    #[serde(rename = "maxItems")]
    max_items: u64,
    #[serde(rename = "minItems")]
    min_items: u64,
}

use serde::{Serialize, Deserialize};
use common_type::CommonType;

// Represents a scalar type
#[derive(Serialize, Deserialize)]
pub struct ScalarType {
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
    _enum: Vec<serde_json::Value>,
    #[serde(rename = "default")]
    default: serde_json::Value,
}

use serde::{Serialize, Deserialize};
use scalar_type::ScalarType;

// Represents a boolean type
#[derive(Serialize, Deserialize)]
pub struct BooleanType {
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
    _enum: Vec<serde_json::Value>,
    #[serde(rename = "default")]
    default: serde_json::Value,
}

use serde::{Serialize, Deserialize};
use scalar_type::ScalarType;

// Represents a number type (contains also integer)
#[derive(Serialize, Deserialize)]
pub struct NumberType {
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
    _enum: Vec<serde_json::Value>,
    #[serde(rename = "default")]
    default: serde_json::Value,
    #[serde(rename = "multipleOf")]
    multiple_of: f64,
    #[serde(rename = "maximum")]
    maximum: f64,
    #[serde(rename = "exclusiveMaximum")]
    exclusive_maximum: bool,
    #[serde(rename = "minimum")]
    minimum: f64,
    #[serde(rename = "exclusiveMinimum")]
    exclusive_minimum: bool,
}

use serde::{Serialize, Deserialize};
use scalar_type::ScalarType;

// Represents a string type
#[derive(Serialize, Deserialize)]
pub struct StringType {
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
    _enum: Vec<serde_json::Value>,
    #[serde(rename = "default")]
    default: serde_json::Value,
    #[serde(rename = "maxLength")]
    max_length: u64,
    #[serde(rename = "minLength")]
    min_length: u64,
    #[serde(rename = "pattern")]
    pattern: String,
}

use serde::{Serialize, Deserialize};
use common_type::CommonType;

// Represents an any type
#[derive(Serialize, Deserialize)]
pub struct AnyType {
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
use reference_type::ReferenceType;

// Represents an intersection type
#[derive(Serialize, Deserialize)]
pub struct IntersectionType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "allOf")]
    all_of: Vec<ReferenceType>,
}

use serde::{Serialize, Deserialize};
use discriminator::Discriminator;
use number_type::NumberType;
use string_type::StringType;
use boolean_type::BooleanType;
use reference_type::ReferenceType;

// Represents an union type. An union type can contain one of the provided types
#[derive(Serialize, Deserialize)]
pub struct UnionType {
    #[serde(rename = "description")]
    description: String,
    #[serde(rename = "discriminator")]
    discriminator: Discriminator,
    #[serde(rename = "oneOf")]
    one_of: Vec<serde_json::Value>,
}

use std::collections::HashMap;

// An object to hold mappings between payload values and schema names or references
pub type DiscriminatorMapping = HashMap<String, String>;

use serde::{Serialize, Deserialize};
use discriminator_mapping::DiscriminatorMapping;

// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
#[derive(Serialize, Deserialize)]
pub struct Discriminator {
    #[serde(rename = "propertyName")]
    property_name: String,
    #[serde(rename = "mapping")]
    mapping: DiscriminatorMapping,
}

use serde::{Serialize, Deserialize};
use template_properties::TemplateProperties;

// Represents a reference type. A reference type points to a specific type at the definitions map
#[derive(Serialize, Deserialize)]
pub struct ReferenceType {
    #[serde(rename = "$ref")]
    _ref: String,
    #[serde(rename = "$template")]
    _template: TemplateProperties,
}

use std::collections::HashMap;
pub type TemplateProperties = HashMap<String, String>;

use serde::{Serialize, Deserialize};

// Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
#[derive(Serialize, Deserialize)]
pub struct GenericType {
    #[serde(rename = "$generic")]
    _generic: String,
}

use std::collections::HashMap;
use struct_type::StructType;
use map_type::MapType;
use reference_type::ReferenceType;

// The definitions map which contains all types
pub type Definitions = HashMap<String, serde_json::Value>;

use std::collections::HashMap;

// Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. 'my_namespace:my_type'
pub type Import = HashMap<String, String>;

use serde::{Serialize, Deserialize};
use import::Import;
use definitions::Definitions;

// The root TypeSchema
#[derive(Serialize, Deserialize)]
pub struct TypeSchema {
    #[serde(rename = "$import")]
    _import: Import,
    #[serde(rename = "definitions")]
    definitions: Definitions,
    #[serde(rename = "$ref")]
    _ref: String,
}
