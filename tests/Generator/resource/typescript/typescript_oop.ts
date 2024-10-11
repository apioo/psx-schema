export interface Human {
    firstName?: string
    parent?: Human
}

import {Human} from "./Human";
export interface Student extends Human {
    matricleNumber?: string
}

export interface Map<P, T> {
    totalResults?: number
    parent?: P
    entries?: Array<T>
}

import {Map} from "./Map";
import {Human} from "./Human";
import {Student} from "./Student";
export interface StudentMap extends Map<Human, Student> {
}

import {Map} from "./Map";
import {Human} from "./Human";
export interface HumanMap extends Map<Human, Human> {
}

import {StudentMap} from "./StudentMap";
export interface RootSchema {
    students?: StudentMap
}
