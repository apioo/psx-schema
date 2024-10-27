use serde::{Serialize, Deserialize};
use property_type::PropertyType;

#[derive(Serialize, Deserialize)]
pub struct Response {
    #[serde(rename = "code")]
    code: Option<u64>,

    #[serde(rename = "contentType")]
    content_type: Option<String>,

    #[serde(rename = "schema")]
    schema: Option<PropertyType>,

}

