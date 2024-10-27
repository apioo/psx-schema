use serde::{Serialize, Deserialize};
use scalar_property_type::ScalarPropertyType;

// Represents a string value
#[derive(Serialize, Deserialize)]
pub struct StringPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "format")]
    format: Option<String>,

}

