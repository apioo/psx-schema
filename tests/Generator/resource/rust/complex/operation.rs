use serde::{Serialize, Deserialize};
use response::Response;
use argument::Argument;

#[derive(Serialize, Deserialize)]
pub struct Operation {
    #[serde(rename = "method")]
    method: Option<String>,

    #[serde(rename = "path")]
    path: Option<String>,

    #[serde(rename = "return")]
    _return: Option<Response>,

    #[serde(rename = "arguments")]
    arguments: Option<std::collections::HashMap<String, Argument>>,

    #[serde(rename = "throws")]
    throws: Option<Vec<Response>>,

    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "stability")]
    stability: Option<u64>,

    #[serde(rename = "security")]
    security: Option<Vec<String>>,

    #[serde(rename = "authorization")]
    authorization: Option<bool>,

    #[serde(rename = "tags")]
    tags: Option<Vec<String>>,

}

