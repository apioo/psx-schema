use serde::{Serialize, Deserialize};
use human_type::HumanType;

#[derive(Serialize, Deserialize)]
pub struct Student {
    #[serde(rename = "firstName")]
    first_name: Option<String>,

    #[serde(rename = "parent")]
    parent: Option<HumanType>,

    #[serde(rename = "matricleNumber")]
    matricle_number: Option<String>,

}

