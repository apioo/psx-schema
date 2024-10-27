use serde::{Serialize, Deserialize};
use property_type::PropertyType;

#[derive(Serialize, Deserialize)]
pub struct Argument {
    #[serde(rename = "in")]
    _in: Option<String>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

    #[serde(rename = "contentType")]
    content_type: Option<String>,

    #[serde(rename = "name")]
    name: Option<String>,

}

