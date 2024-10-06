use serde::{Serialize, Deserialize};
use human::Human;
#[derive(Serialize, Deserialize)]
pub struct Human {
    #[serde(rename = "firstName")]
    first_name: Option<String>,

    #[serde(rename = "parent")]
    parent: Option<Human>,

}

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

use serde::{Serialize, Deserialize};
use map::Map;
use student::Student;
#[derive(Serialize, Deserialize)]
pub struct StudentMap {
    #[serde(rename = "totalResults")]
    total_results: Option<u64>,

    #[serde(rename = "entries")]
    entries: Option<Vec<T>>,

}

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
pub struct Map {
    #[serde(rename = "totalResults")]
    total_results: Option<u64>,

    #[serde(rename = "entries")]
    entries: Option<Vec<T>>,

}

use serde::{Serialize, Deserialize};
use student_map::StudentMap;
#[derive(Serialize, Deserialize)]
pub struct RootSchema {
    #[serde(rename = "students")]
    students: Option<StudentMap>,

}
