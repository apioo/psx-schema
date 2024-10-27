use serde::{Serialize, Deserialize};
use property_type::PropertyType;

// Base collection property type
#[derive(Serialize, Deserialize)]
pub struct CollectionPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

