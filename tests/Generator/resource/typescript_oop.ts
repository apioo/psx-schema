
export interface Human {
    firstName?: string
}



import {Human} from "./Human";

export interface Student extends Human {
    matricleNumber?: string
}



import {Map} from "./Map";
import {Student} from "./Student";

export type StudentMap = Map<Student>;



export interface Map<T> {
    totalResults?: number
    entries?: Array<T>
}



import {StudentMap} from "./StudentMap";

export interface RootSchema {
    students?: StudentMap
}

