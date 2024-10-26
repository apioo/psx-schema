use serde::{Serialize, Deserialize};
use human::Human;

#[derive(Serialize, Deserialize)]
pub struct Human {
    #[serde(rename = "firstName")]
    first_name: Option<String>,

    #[serde(rename = "parent")]
    parent: Option<Human>,

}

