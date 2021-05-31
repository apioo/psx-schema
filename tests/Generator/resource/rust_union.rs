struct Creature {
    kind: String,
}

struct Human {
    *Creature
    firstName: String,
}

struct Animal {
    *Creature
    nickname: String,
}

struct Union {
    union: Object,
    intersection: Object,
    discriminator: Object,
}
