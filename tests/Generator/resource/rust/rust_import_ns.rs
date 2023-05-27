mod FooBar;

use serde::{Serialize, Deserialize};
use student_map::StudentMap;
use student::Student;
#[derive(Serialize, Deserialize)]
pub struct Import {
    #[serde(rename = "students")]
    students: My::Import::StudentMap,
    #[serde(rename = "student")]
    student: My::Import::Student,
}

mod FooBar;

use serde::{Serialize, Deserialize};
use student::Student;
#[derive(Serialize, Deserialize)]
pub struct MyMap {
    #[serde(rename = "matricleNumber")]
    matricle_number: String,
    #[serde(rename = "firstName")]
    first_name: String,
}
