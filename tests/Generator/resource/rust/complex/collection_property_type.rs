use serde::{Serialize, Deserialize};
use array_property_type::ArrayPropertyType;
use map_property_type::MapPropertyType;
use property_type::PropertyType;

// Base collection property type
#[derive(Serialize, Deserialize)]
pub struct CollectionPropertyType {
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

