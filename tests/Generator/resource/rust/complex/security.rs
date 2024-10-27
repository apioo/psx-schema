use serde::{Serialize, Deserialize};
use security_http_basic::SecurityHttpBasic;
use security_http_bearer::SecurityHttpBearer;
use security_api_key::SecurityApiKey;
use security_o_auth2::SecurityOAuth;

#[derive(Serialize, Deserialize)]
pub struct Security {
    #[serde(rename = "type")]
    _type: Option<String>,

}

