mod FooBar;

use serde::{Serialize, Deserialize};
use student_map::StudentMap;
use student::Student;

#[derive(Serialize, Deserialize)]
pub struct Import {
    #[serde(rename = "students")]
    students: Option<My::Import::StudentMap>,

    #[serde(rename = "student")]
    student: Option<My::Import::Student>,

}

