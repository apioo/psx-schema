use serde::{Serialize, Deserialize};
use student::Student;
use human::Human;

#[derive(Serialize, Deserialize)]
pub struct MyMap {
    #[serde(rename = "matricleNumber")]
    matricle_number: Option<String>,

    #[serde(rename = "firstName")]
    first_name: Option<String>,

    #[serde(rename = "parent")]
    parent: Option<Human>,

}

