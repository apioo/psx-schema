use serde::{Serialize, Deserialize};
use array_definition_type::ArrayDefinitionType;
use map_definition_type::MapDefinitionType;
use struct_definition_type::StructDefinitionType;

// Base definition type
#[derive(Serialize, Deserialize)]
pub struct DefinitionType {
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "type")]
    _type: Option<String>,

}

