use serde::{Serialize, Deserialize};
use common_type::CommonType;

// Represents an any type
#[derive(Serialize, Deserialize)]
pub struct AnyType {
    #[serde(rename = "description")]
    description: Option<String>,
    #[serde(rename = "type")]
    _type: Option<String>,
    #[serde(rename = "nullable")]
    nullable: Option<bool>,
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,
    #[serde(rename = "readonly")]
    readonly: Option<bool>,
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
    description: Option<String>,
    #[serde(rename = "type")]
    _type: Option<String>,
    #[serde(rename = "nullable")]
    nullable: Option<bool>,
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,
    #[serde(rename = "readonly")]
    readonly: Option<bool>,
    #[serde(rename = "items")]
    items: Option<serde_json::Value>,
    #[serde(rename = "maxItems")]
    max_items: Option<u64>,
    #[serde(rename = "minItems")]
    min_items: Option<u64>,
}

use serde::{Serialize, Deserialize};
use scalar_type::ScalarType;

// Represents a boolean type
#[derive(Serialize, Deserialize)]
pub struct BooleanType {
    #[serde(rename = "format")]
    format: Option<String>,
    #[serde(rename = "enum")]
    _enum: Option<Vec<serde_json::Value>>,
    #[serde(rename = "default")]
    default: Option<serde_json::Value>,
    #[serde(rename = "description")]
    description: Option<String>,
    #[serde(rename = "type")]
    _type: Option<String>,
    #[serde(rename = "nullable")]
    nullable: Option<bool>,
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,
    #[serde(rename = "readonly")]
    readonly: Option<bool>,
}

use serde::{Serialize, Deserialize};

// Represents a base type. Every type extends from this common type and shares the defined properties
#[derive(Serialize, Deserialize)]
pub struct CommonType {
    #[serde(rename = "description")]
    description: Option<String>,
    #[serde(rename = "type")]
    _type: Option<String>,
    #[serde(rename = "nullable")]
    nullable: Option<bool>,
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,
    #[serde(rename = "readonly")]
    readonly: Option<bool>,
}

use serde::{Serialize, Deserialize};
use std::collections::HashMap;

// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
#[derive(Serialize, Deserialize)]
pub struct Discriminator {
    #[serde(rename = "propertyName")]
    property_name: Option<String>,
    #[serde(rename = "mapping")]
    mapping: Option<HashMap<String, String>>,
}

use serde::{Serialize, Deserialize};

// Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
#[derive(Serialize, Deserialize)]
pub struct GenericType {
    #[serde(rename = "$generic")]
    _generic: Option<String>,
}

use serde::{Serialize, Deserialize};
use reference_type::ReferenceType;

// Represents an intersection type
#[derive(Serialize, Deserialize)]
pub struct IntersectionType {
    #[serde(rename = "description")]
    description: Option<String>,
    #[serde(rename = "allOf")]
    all_of: Option<Vec<ReferenceType>>,
}

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
    description: Option<String>,
    #[serde(rename = "type")]
    _type: Option<String>,
    #[serde(rename = "nullable")]
    nullable: Option<bool>,
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,
    #[serde(rename = "readonly")]
    readonly: Option<bool>,
    #[serde(rename = "additionalProperties")]
    additional_properties: Option<serde_json::Value>,
    #[serde(rename = "maxProperties")]
    max_properties: Option<u64>,
    #[serde(rename = "minProperties")]
    min_properties: Option<u64>,
}

use serde::{Serialize, Deserialize};
use scalar_type::ScalarType;

// Represents a number type (contains also integer)
#[derive(Serialize, Deserialize)]
pub struct NumberType {
    #[serde(rename = "format")]
    format: Option<String>,
    #[serde(rename = "enum")]
    _enum: Option<Vec<serde_json::Value>>,
    #[serde(rename = "default")]
    default: Option<serde_json::Value>,
    #[serde(rename = "description")]
    description: Option<String>,
    #[serde(rename = "type")]
    _type: Option<String>,
    #[serde(rename = "nullable")]
    nullable: Option<bool>,
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,
    #[serde(rename = "readonly")]
    readonly: Option<bool>,
    #[serde(rename = "multipleOf")]
    multiple_of: Option<f64>,
    #[serde(rename = "maximum")]
    maximum: Option<f64>,
    #[serde(rename = "exclusiveMaximum")]
    exclusive_maximum: Option<bool>,
    #[serde(rename = "minimum")]
    minimum: Option<f64>,
    #[serde(rename = "exclusiveMinimum")]
    exclusive_minimum: Option<bool>,
}

use serde::{Serialize, Deserialize};
use std::collections::HashMap;

// Represents a reference type. A reference type points to a specific type at the definitions map
#[derive(Serialize, Deserialize)]
pub struct ReferenceType {
    #[serde(rename = "$ref")]
    _ref: Option<String>,
    #[serde(rename = "$template")]
    _template: Option<HashMap<String, String>>,
}

use serde::{Serialize, Deserialize};
use common_type::CommonType;

// Represents a scalar type
#[derive(Serialize, Deserialize)]
pub struct ScalarType {
    #[serde(rename = "description")]
    description: Option<String>,
    #[serde(rename = "type")]
    _type: Option<String>,
    #[serde(rename = "nullable")]
    nullable: Option<bool>,
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,
    #[serde(rename = "readonly")]
    readonly: Option<bool>,
    #[serde(rename = "format")]
    format: Option<String>,
    #[serde(rename = "enum")]
    _enum: Option<Vec<serde_json::Value>>,
    #[serde(rename = "default")]
    default: Option<serde_json::Value>,
}

use serde::{Serialize, Deserialize};
use scalar_type::ScalarType;

// Represents a string type
#[derive(Serialize, Deserialize)]
pub struct StringType {
    #[serde(rename = "description")]
    description: Option<String>,
    #[serde(rename = "type")]
    _type: Option<String>,
    #[serde(rename = "nullable")]
    nullable: Option<bool>,
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,
    #[serde(rename = "readonly")]
    readonly: Option<bool>,
    #[serde(rename = "format")]
    format: Option<String>,
    #[serde(rename = "enum")]
    _enum: Option<Vec<serde_json::Value>>,
    #[serde(rename = "default")]
    default: Option<serde_json::Value>,
    #[serde(rename = "maxLength")]
    max_length: Option<u64>,
    #[serde(rename = "minLength")]
    min_length: Option<u64>,
    #[serde(rename = "pattern")]
    pattern: Option<String>,
}

use serde::{Serialize, Deserialize};
use std::collections::HashMap;
use common_type::CommonType;
use map_type::MapType;
use array_type::ArrayType;
use boolean_type::BooleanType;
use number_type::NumberType;
use string_type::StringType;
use any_type::AnyType;
use intersection_type::IntersectionType;
use union_type::UnionType;
use reference_type::ReferenceType;
use generic_type::GenericType;

// Represents a struct type. A struct type contains a fix set of defined properties
#[derive(Serialize, Deserialize)]
pub struct StructType {
    #[serde(rename = "description")]
    description: Option<String>,
    #[serde(rename = "type")]
    _type: Option<String>,
    #[serde(rename = "nullable")]
    nullable: Option<bool>,
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,
    #[serde(rename = "readonly")]
    readonly: Option<bool>,
    #[serde(rename = "$final")]
    _final: Option<bool>,
    #[serde(rename = "$extends")]
    _extends: Option<String>,
    #[serde(rename = "properties")]
    properties: Option<HashMap<String, serde_json::Value>>,
    #[serde(rename = "required")]
    required: Option<Vec<String>>,
}

use serde::{Serialize, Deserialize};
use std::collections::HashMap;
use struct_type::StructType;
use map_type::MapType;
use reference_type::ReferenceType;

// The root TypeSchema
#[derive(Serialize, Deserialize)]
pub struct TypeSchema {
    #[serde(rename = "$import")]
    _import: Option<HashMap<String, String>>,
    #[serde(rename = "definitions")]
    definitions: Option<HashMap<String, serde_json::Value>>,
    #[serde(rename = "$ref")]
    _ref: Option<String>,
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
    description: Option<String>,
    #[serde(rename = "discriminator")]
    discriminator: Option<Discriminator>,
    #[serde(rename = "oneOf")]
    one_of: Option<Vec<serde_json::Value>>,
}
