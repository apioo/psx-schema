use serde::{Serialize, Deserialize};
use argument::Argument;
use response::Response;

#[derive(Serialize, Deserialize)]
pub struct Operation {
    #[serde(rename = "arguments")]
    arguments: Option<std::collections::HashMap<String, Argument>>,

    #[serde(rename = "authorization")]
    authorization: Option<bool>,

    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "method")]
    method: Option<String>,

    #[serde(rename = "path")]
    path: Option<String>,

    #[serde(rename = "return")]
    _return: Option<Response>,

    #[serde(rename = "security")]
    security: Option<Vec<String>>,

    #[serde(rename = "stability")]
    stability: Option<u64>,

    #[serde(rename = "throws")]
    throws: Option<Vec<Response>>,

}

