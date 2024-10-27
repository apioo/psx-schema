use serde::{Serialize, Deserialize};
use struct_definition_type::StructDefinitionType;
use map_definition_type::MapDefinitionType;
use array_definition_type::ArrayDefinitionType;

// Base definition type
#[derive(Serialize, Deserialize)]
pub struct DefinitionType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

}

