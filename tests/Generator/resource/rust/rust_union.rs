use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
pub struct Creature {
    #[serde(rename = "kind")]
    kind: String,
}

use serde::{Serialize, Deserialize};
use creature::Creature;
#[derive(Serialize, Deserialize)]
pub struct Human {
    #[serde(rename = "kind")]
    kind: String,
    #[serde(rename = "firstName")]
    first_name: String,
}

use serde::{Serialize, Deserialize};
use creature::Creature;
#[derive(Serialize, Deserialize)]
pub struct Animal {
    #[serde(rename = "kind")]
    kind: String,
    #[serde(rename = "nickname")]
    nickname: String,
}

use serde::{Serialize, Deserialize};
use human::Human;
use animal::Animal;
#[derive(Serialize, Deserialize)]
pub struct Union {
    #[serde(rename = "union")]
    union: serde_json::Value,
    #[serde(rename = "intersection")]
    intersection: serde_json::Value,
    #[serde(rename = "discriminator")]
    discriminator: serde_json::Value,
}
