use serde::{Deserialize, Serialize};
#[derive(Serialize, Deserialize)]
struct Import {
    students: StudentMap,
    student: Student,
}

use serde::{Deserialize, Serialize};
#[derive(Serialize, Deserialize)]
struct MyMap {
    *Student
}
