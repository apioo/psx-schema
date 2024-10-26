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

