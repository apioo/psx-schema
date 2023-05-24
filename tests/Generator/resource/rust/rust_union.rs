use serde::{Deserialize, Serialize};
#[derive(Serialize, Deserialize)]
struct Creature {
    kind: String,
}

use serde::{Deserialize, Serialize};
#[derive(Serialize, Deserialize)]
struct Human {
    *Creature
    firstName: String,
}

use serde::{Deserialize, Serialize};
#[derive(Serialize, Deserialize)]
struct Animal {
    *Creature
    nickname: String,
}

use serde::{Deserialize, Serialize};
#[derive(Serialize, Deserialize)]
struct Union {
    union: Object,
    intersection: Object,
    discriminator: Object,
}
