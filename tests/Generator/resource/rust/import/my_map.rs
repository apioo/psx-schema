use serde::{Serialize, Deserialize};
use student::Student;
use human_type::HumanType;

#[derive(Serialize, Deserialize)]
pub struct MyMap {
    #[serde(rename = "matricleNumber")]
    matricle_number: Option<String>,

    #[serde(rename = "firstName")]
    first_name: Option<String>,

    #[serde(rename = "parent")]
    parent: Option<HumanType>,

}

