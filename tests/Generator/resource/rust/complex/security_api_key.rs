use serde::{Serialize, Deserialize};
use security::Security;

#[derive(Serialize, Deserialize)]
pub struct SecurityApiKey {
    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "in")]
    _in: Option<String>,

    #[serde(rename = "name")]
    name: Option<String>,

}

