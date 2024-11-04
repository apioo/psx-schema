use serde::{Serialize, Deserialize};
use human_type::HumanType;

#[derive(Serialize, Deserialize)]
pub struct HumanType {
    #[serde(rename = "firstName")]
    first_name: Option<String>,

    #[serde(rename = "parent")]
    parent: Option<HumanType>,

}

