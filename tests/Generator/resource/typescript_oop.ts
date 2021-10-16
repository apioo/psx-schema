export interface Human {
    firstName?: string
}

import {Human} from "./Human";
import {Map} from "./Map";
import {Student} from "./Student";
import {StudentMap} from "./StudentMap";

export interface Student extends Human {
    matricleNumber?: string
}

export type StudentMap = Map<Student>;

export interface Map<T> {
    totalResults?: number
    entries?: Array<T>
}

export interface RootSchema {
    students?: StudentMap
}
