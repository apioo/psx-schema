use serde::{Serialize, Deserialize};
use student_map::StudentMap;

#[derive(Serialize, Deserialize)]
pub struct RootSchema {
    #[serde(rename = "students")]
    students: Option<StudentMap>,

}

