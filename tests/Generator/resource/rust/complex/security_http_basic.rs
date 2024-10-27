use serde::{Serialize, Deserialize};
use security::Security;

#[derive(Serialize, Deserialize)]
pub struct SecurityHttpBasic {
    #[serde(rename = "type")]
    _type: Option<String>,

}

