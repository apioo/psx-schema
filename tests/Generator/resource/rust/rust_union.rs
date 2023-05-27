use serde::{Serialize, Deserialize};
#[derive(Serialize, Deserialize)]
pub struct Creature {
    #[serde(rename = "kind")]
    kind: Option<String>,
}

use serde::{Serialize, Deserialize};
use creature::Creature;
#[derive(Serialize, Deserialize)]
pub struct Human {
    #[serde(rename = "kind")]
    kind: Option<String>,
    #[serde(rename = "firstName")]
    first_name: Option<String>,
}

use serde::{Serialize, Deserialize};
use creature::Creature;
#[derive(Serialize, Deserialize)]
pub struct Animal {
    #[serde(rename = "kind")]
    kind: Option<String>,
    #[serde(rename = "nickname")]
    nickname: Option<String>,
}

use serde::{Serialize, Deserialize};
use human::Human;
use animal::Animal;
#[derive(Serialize, Deserialize)]
pub struct Union {
    #[serde(rename = "union")]
    union: Option<serde_json::Value>,
    #[serde(rename = "intersection")]
    intersection: Option<serde_json::Value>,
    #[serde(rename = "discriminator")]
    discriminator: Option<serde_json::Value>,
}
