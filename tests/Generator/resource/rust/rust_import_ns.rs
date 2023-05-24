package FooBar

use serde::{Deserialize, Serialize};
#[derive(Serialize, Deserialize)]
struct Import {
    students: My::Import.StudentMap,
    student: My::Import.Student,
}

package FooBar

use serde::{Deserialize, Serialize};
#[derive(Serialize, Deserialize)]
struct MyMap {
    *My::Import.Student
}
