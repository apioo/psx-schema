use serde::{Serialize, Deserialize};
use struct_definition_type::StructDefinitionType;
use map_definition_type::MapDefinitionType;
use array_definition_type::ArrayDefinitionType;

// Base definition type
#[derive(Serialize, Deserialize)]
pub struct DefinitionType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

}

use serde::{Serialize, Deserialize};
use definition_type::DefinitionType;
use property_type::PropertyType;

// Represents a struct which contains a fixed set of defined properties
#[derive(Serialize, Deserialize)]
pub struct StructDefinitionType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "parent")]
    parent: Option<String>,

    #[serde(rename = "base")]
    base: Option<bool>,

    #[serde(rename = "properties")]
    properties: Option<HashMap<String, PropertyType>>,

    #[serde(rename = "discriminator")]
    discriminator: Option<String>,

    #[serde(rename = "mapping")]
    mapping: Option<HashMap<String, String>>,

    #[serde(rename = "template")]
    template: Option<HashMap<String, String>>,

}

use serde::{Serialize, Deserialize};
use definition_type::DefinitionType;
use map_definition_type::MapDefinitionType;
use array_definition_type::ArrayDefinitionType;
use property_type::PropertyType;

// Base type for the map and array collection type
#[derive(Serialize, Deserialize)]
pub struct CollectionDefinitionType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

use serde::{Serialize, Deserialize};
use collection_definition_type::CollectionDefinitionType;
use property_type::PropertyType;

// Represents a map which contains a dynamic set of key value entries
#[derive(Serialize, Deserialize)]
pub struct MapDefinitionType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

use serde::{Serialize, Deserialize};
use collection_definition_type::CollectionDefinitionType;
use property_type::PropertyType;

// Represents an array which contains a dynamic list of values
#[derive(Serialize, Deserialize)]
pub struct ArrayDefinitionType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

use serde::{Serialize, Deserialize};
use integer_property_type::IntegerPropertyType;
use number_property_type::NumberPropertyType;
use string_property_type::StringPropertyType;
use boolean_property_type::BooleanPropertyType;
use map_property_type::MapPropertyType;
use array_property_type::ArrayPropertyType;
use any_property_type::AnyPropertyType;
use generic_property_type::GenericPropertyType;
use reference_property_type::ReferencePropertyType;

// Base property type
#[derive(Serialize, Deserialize)]
pub struct PropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

}

use serde::{Serialize, Deserialize};
use property_type::PropertyType;
use integer_property_type::IntegerPropertyType;
use number_property_type::NumberPropertyType;
use string_property_type::StringPropertyType;
use boolean_property_type::BooleanPropertyType;

// Base scalar property type
#[derive(Serialize, Deserialize)]
pub struct ScalarPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

}

use serde::{Serialize, Deserialize};
use scalar_property_type::ScalarPropertyType;

// Represents an integer value
#[derive(Serialize, Deserialize)]
pub struct IntegerPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

}

use serde::{Serialize, Deserialize};
use scalar_property_type::ScalarPropertyType;

// Represents a float value
#[derive(Serialize, Deserialize)]
pub struct NumberPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

}

use serde::{Serialize, Deserialize};
use scalar_property_type::ScalarPropertyType;

// Represents a string value
#[derive(Serialize, Deserialize)]
pub struct StringPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "format")]
    format: Option<String>,

}

use serde::{Serialize, Deserialize};
use scalar_property_type::ScalarPropertyType;

// Represents a boolean value
#[derive(Serialize, Deserialize)]
pub struct BooleanPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

}

use serde::{Serialize, Deserialize};
use property_type::PropertyType;
use map_property_type::MapPropertyType;
use array_property_type::ArrayPropertyType;

// Base collection property type
#[derive(Serialize, Deserialize)]
pub struct CollectionPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

use serde::{Serialize, Deserialize};
use collection_property_type::CollectionPropertyType;
use property_type::PropertyType;

// Represents a map which contains a dynamic set of key value entries
#[derive(Serialize, Deserialize)]
pub struct MapPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

use serde::{Serialize, Deserialize};
use collection_property_type::CollectionPropertyType;
use property_type::PropertyType;

// Represents an array which contains a dynamic list of values
#[derive(Serialize, Deserialize)]
pub struct ArrayPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

use serde::{Serialize, Deserialize};
use property_type::PropertyType;

// Represents an any value which allows any kind of value
#[derive(Serialize, Deserialize)]
pub struct AnyPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

}

use serde::{Serialize, Deserialize};
use property_type::PropertyType;

// Represents a generic value which can be replaced with a dynamic type
#[derive(Serialize, Deserialize)]
pub struct GenericPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "name")]
    name: Option<String>,

}

use serde::{Serialize, Deserialize};
use property_type::PropertyType;

// Represents a reference to a definition type
#[derive(Serialize, Deserialize)]
pub struct ReferencePropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "target")]
    target: Option<String>,

}

use serde::{Serialize, Deserialize};
use definition_type::DefinitionType;
#[derive(Serialize, Deserialize)]
pub struct Specification {
    #[serde(rename = "import")]
    import: Option<HashMap<String, String>>,

    #[serde(rename = "definitions")]
    definitions: Option<HashMap<String, DefinitionType>>,

    #[serde(rename = "root")]
    root: Option<String>,

}
