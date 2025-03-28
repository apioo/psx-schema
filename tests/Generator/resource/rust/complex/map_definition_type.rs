use serde::{Serialize, Deserialize};
use collection_definition_type::CollectionDefinitionType;
use property_type::PropertyType;

// Represents a map which contains a dynamic set of key value entries of the same type
#[derive(Serialize, Deserialize)]
pub struct MapDefinitionType {
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

