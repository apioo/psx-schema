use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
pub struct Human {
    #[serde(rename = "firstName")]
    first_name: String,
}

use serde::{Serialize, Deserialize};
use human::Human;
#[derive(Serialize, Deserialize)]
pub struct Student {
    #[serde(rename = "firstName")]
    first_name: String,
    #[serde(rename = "matricleNumber")]
    matricle_number: String,
}

use map::Map;
use student::Student;
pub type StudentMap = Map;

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
pub struct Map {
    #[serde(rename = "totalResults")]
    total_results: u64,
    #[serde(rename = "entries")]
    entries: Vec<T>,
}

use serde::{Serialize, Deserialize};
use student_map::StudentMap;
#[derive(Serialize, Deserialize)]
pub struct RootSchema {
    #[serde(rename = "students")]
    students: StudentMap,
}
