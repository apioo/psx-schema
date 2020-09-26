export interface Creature {
    kind: string
}

export interface Human extends Creature {
    firstName?: string
}

export interface Animal extends Creature {
    nickname?: string
}

export interface Union {
    union?: Human | Animal
    intersection?: Human & Animal
    discriminator?: Human | Animal
}
