use serde::{Serialize, Deserialize};
use property_type::PropertyType;

// Represents an any value which allows any kind of value
#[derive(Serialize, Deserialize)]
pub struct AnyPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

}

