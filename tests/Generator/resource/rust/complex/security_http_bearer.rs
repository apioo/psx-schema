use serde::{Serialize, Deserialize};
use security::Security;

#[derive(Serialize, Deserialize)]
pub struct SecurityHttpBearer {
    #[serde(rename = "type")]
    _type: Option<String>,

}

