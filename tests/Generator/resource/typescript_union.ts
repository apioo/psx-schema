
export interface Creature {
    kind: string
}



import {Creature} from "./Creature";

export interface Human extends Creature {
    firstName?: string
}



import {Creature} from "./Creature";

export interface Animal extends Creature {
    nickname?: string
}



import {Human} from "./Human";
import {Animal} from "./Animal";

export interface Union {
    union?: Human | Animal
    intersection?: Human & Animal
    discriminator?: Human | Animal
}

