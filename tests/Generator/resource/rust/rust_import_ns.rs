package FooBar

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
struct Import {
    #[serde(rename = "students")]
    students: My::Import.StudentMap,
    #[serde(rename = "student")]
    student: My::Import.Student,
}

package FooBar

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
struct MyMap {
    #[serde(rename = "matricleNumber")]
    matricleNumber: String,
    #[serde(rename = "firstName")]
    firstName: String,
}
