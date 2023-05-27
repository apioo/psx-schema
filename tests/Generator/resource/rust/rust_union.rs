use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
struct Creature {
    #[serde(rename = "kind")]
    kind: String,
}

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
struct Human {
    #[serde(rename = "kind")]
    kind: String,
    #[serde(rename = "firstName")]
    firstName: String,
}

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
struct Animal {
    #[serde(rename = "kind")]
    kind: String,
    #[serde(rename = "nickname")]
    nickname: String,
}

use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
struct Union {
    #[serde(rename = "union")]
    union: Object,
    #[serde(rename = "intersection")]
    intersection: Object,
    #[serde(rename = "discriminator")]
    discriminator: Object,
}
