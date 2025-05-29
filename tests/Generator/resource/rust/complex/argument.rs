use serde::{Serialize, Deserialize};
use property_type::PropertyType;

// Describes arguments of the operation
#[derive(Serialize, Deserialize)]
pub struct Argument {
    #[serde(rename = "contentType")]
    content_type: Option<String>,

    #[serde(rename = "in")]
    _in: Option<String>,

    #[serde(rename = "name")]
    name: Option<String>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

