use serde::{Deserialize, Serialize};
#[derive(Serialize, Deserialize)]
struct Human {
    firstName: String,
}

use serde::{Deserialize, Serialize};
#[derive(Serialize, Deserialize)]
struct Student {
    *Human
    matricleNumber: String,
}

use serde::{Deserialize, Serialize};
type StudentMap = Map

use serde::{Deserialize, Serialize};
#[derive(Serialize, Deserialize)]
struct Map {
    totalResults: u64,
    entries: Vec<T>,
}

use serde::{Deserialize, Serialize};
#[derive(Serialize, Deserialize)]
struct RootSchema {
    students: StudentMap,
}
