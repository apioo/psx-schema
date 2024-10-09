export class Human {
    firstName?: string
    parent?: Human
}

import {Human} from "./Human";
export class Student extends Human {
    matricleNumber?: string
}

export class Map<P, T> {
    totalResults?: number
    parent?: P
    entries?: Array<T>
}

import {Map} from "./Map";
import {Human} from "./Human";
import {Student} from "./Student";
export class StudentMap extends Map<Human, Student> {
}

import {Map} from "./Map";
import {Human} from "./Human";
export class HumanMap extends Map<Human, Human> {
}

import {StudentMap} from "./StudentMap";
export class RootSchema {
    students?: StudentMap
}
