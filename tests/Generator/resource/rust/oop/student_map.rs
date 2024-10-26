use serde::{Serialize, Deserialize};
use map::Map;
use human::Human;
use student::Student;

#[derive(Serialize, Deserialize)]
pub struct StudentMap {
    #[serde(rename = "totalResults")]
    total_results: Option<u64>,

    #[serde(rename = "parent")]
    parent: Option<Human>,

    #[serde(rename = "entries")]
    entries: Option<Vec<Student>>,

}

