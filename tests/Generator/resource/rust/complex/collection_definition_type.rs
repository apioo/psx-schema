use serde::{Serialize, Deserialize};
use map_definition_type::MapDefinitionType;
use array_definition_type::ArrayDefinitionType;
use definition_type::DefinitionType;
use property_type::PropertyType;

// Base collection type
#[derive(Serialize, Deserialize)]
pub struct CollectionDefinitionType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

