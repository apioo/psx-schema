use serde::{Serialize, Deserialize};
use map::Map;
use human_type::HumanType;
use student::Student;

#[derive(Serialize, Deserialize)]
pub struct StudentMap {
    #[serde(rename = "totalResults")]
    total_results: Option<u64>,

    #[serde(rename = "parent")]
    parent: Option<HumanType>,

    #[serde(rename = "entries")]
    entries: Option<Vec<Student>>,

}

