interface Human {
    firstName?: string
}

interface Student extends Human {
    matricleNumber?: string
}

type StudentMap = Map<Student>;

interface Map<T> {
    totalResults?: number
    entries?: Array<T>
}

interface RootSchema {
    students?: StudentMap
}
