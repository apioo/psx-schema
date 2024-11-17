use serde::{Serialize, Deserialize};
use scalar_property_type::ScalarPropertyType;

// Represents a float value
#[derive(Serialize, Deserialize)]
pub struct NumberPropertyType {
    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

}

