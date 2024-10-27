use serde::{Serialize, Deserialize};
use definition_type::DefinitionType;
use reference_property_type::ReferencePropertyType;
use property_type::PropertyType;

// A struct represents a class/structure with a fix set of defined properties.
#[derive(Serialize, Deserialize)]
pub struct StructDefinitionType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "parent")]
    parent: Option<ReferencePropertyType>,

    #[serde(rename = "base")]
    base: Option<bool>,

    #[serde(rename = "properties")]
    properties: Option<HashMap<String, PropertyType>>,

    #[serde(rename = "discriminator")]
    discriminator: Option<String>,

    #[serde(rename = "mapping")]
    mapping: Option<HashMap<String, String>>,

}

