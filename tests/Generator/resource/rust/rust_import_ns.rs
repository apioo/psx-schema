mod FooBar;

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
pub struct Import {
    #[serde(rename = "students")]
    students: Option<My::Import::StudentMap>,

    #[serde(rename = "student")]
    student: Option<My::Import::Student>,

}

mod FooBar;

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
pub struct MyMap {
    #[serde(rename = "matricleNumber")]
    matricle_number: Option<String>,

    #[serde(rename = "firstName")]
    first_name: Option<String>,

    #[serde(rename = "parent")]
    parent: Option<My::Import::Human>,

}
