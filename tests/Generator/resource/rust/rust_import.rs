use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
struct Import {
    #[serde(rename = "students")]
    students: StudentMap,
    #[serde(rename = "student")]
    student: Student,
}

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
struct MyMap {
    #[serde(rename = "matricleNumber")]
    matricleNumber: String,
    #[serde(rename = "firstName")]
    firstName: String,
}
