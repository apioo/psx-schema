use serde::{Serialize, Deserialize};
use property_type::PropertyType;

// Represents a reference to a definition type
#[derive(Serialize, Deserialize)]
pub struct ReferencePropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "target")]
    target: Option<String>,

}

