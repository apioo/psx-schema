use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
struct Human {
    #[serde(rename = "firstName")]
    firstName: String,
}

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
struct Student {
    #[serde(rename = "firstName")]
    firstName: String,
    #[serde(rename = "matricleNumber")]
    matricleNumber: String,
}

type StudentMap = Map

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
struct Map {
    #[serde(rename = "totalResults")]
    totalResults: u64,
    #[serde(rename = "entries")]
    entries: Vec<T>,
}

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
struct RootSchema {
    #[serde(rename = "students")]
    students: StudentMap,
}
