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

