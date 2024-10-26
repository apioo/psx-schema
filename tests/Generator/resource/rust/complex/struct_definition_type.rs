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

