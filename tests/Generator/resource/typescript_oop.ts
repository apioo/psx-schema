export interface Human {
    firstName?: string
}

export interface Student extends Human {
    matricleNumber?: string
}

type StudentMap = Map<Student>;

export interface Map<T> {
    totalResults?: number
    entries?: Array<T>
}

export interface RootSchema {
    students?: StudentMap
}
