

export interface Human {
    firstName?: string
}



export interface Student extends Human {
    matricleNumber?: string
}

export type StudentMap = Map<Student>;



export interface Map<T> {
    totalResults?: number
    entries?: Array<T>
}


import {StudentMap} from "./StudentMap";

export interface RootSchema {
    students?: StudentMap
}
