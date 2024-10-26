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

