export class Human {
    firstName?: string
    parent?: Human
}

import {Human} from "./Human";
export class Student extends Human {
    matricleNumber?: string
}

export class Map<T> {
    totalResults?: number
    entries?: Array<T>
}

import {Map} from "./Map";
import {Student} from "./Student";
export class StudentMap extends Map<Student> {
}

import {StudentMap} from "./StudentMap";
export class RootSchema {
    students?: StudentMap
}
