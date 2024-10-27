use serde::{Serialize, Deserialize};
use property_type::PropertyType;

// Represents a generic value which can be replaced with a dynamic type
#[derive(Serialize, Deserialize)]
pub struct GenericPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "name")]
    name: Option<String>,

}

