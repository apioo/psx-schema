use serde::{Serialize, Deserialize};
use collection_property_type::CollectionPropertyType;
use property_type::PropertyType;

// Represents a map which contains a dynamic set of key value entries
#[derive(Serialize, Deserialize)]
pub struct MapPropertyType {
    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

