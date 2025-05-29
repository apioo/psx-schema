use serde::{Serialize, Deserialize};
use security::Security;

#[derive(Serialize, Deserialize)]
pub struct SecurityOAuth {
    #[serde(rename = "type")]
    _type: Option<String>,

    #[serde(rename = "authorizationUrl")]
    authorization_url: Option<String>,

    #[serde(rename = "scopes")]
    scopes: Option<Vec<String>>,

    #[serde(rename = "tokenUrl")]
    token_url: Option<String>,

}

