use serde::{Serialize, Deserialize};
use collection_property_type::CollectionPropertyType;
use property_type::PropertyType;

// Represents an array which contains a dynamic list of values
#[derive(Serialize, Deserialize)]
pub struct ArrayPropertyType {
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

