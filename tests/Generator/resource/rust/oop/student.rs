use serde::{Serialize, Deserialize};
use human::Human;

#[derive(Serialize, Deserialize)]
pub struct Student {
    #[serde(rename = "firstName")]
    first_name: Option<String>,

    #[serde(rename = "parent")]
    parent: Option<Human>,

    #[serde(rename = "matricleNumber")]
    matricle_number: Option<String>,

}

