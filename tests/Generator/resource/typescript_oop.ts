interface Human {
    firstName?: number
}

interface Student extends Human {
    matricleNumber?: number
}

type StudentMap = Map<Student>;

interface Map<T> {
    totalResults?: number
    entries?: Array<T>
}

interface RootSchema {
    students?: StudentMap
}
