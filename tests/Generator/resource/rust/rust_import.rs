use serde::{Serialize, Deserialize};
use student_map::StudentMap;
use student::Student;
#[derive(Serialize, Deserialize)]
pub struct Import {
    #[serde(rename = "students")]
    students: Option<StudentMap>,
    #[serde(rename = "student")]
    student: Option<Student>,
}

use serde::{Serialize, Deserialize};
use student::Student;
#[derive(Serialize, Deserialize)]
pub struct MyMap {
    #[serde(rename = "matricleNumber")]
    matricle_number: Option<String>,
    #[serde(rename = "firstName")]
    first_name: Option<String>,
}
