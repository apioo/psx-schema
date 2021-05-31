struct Human {
    firstName: String,
}

struct Student {
    *Human
    matricleNumber: String,
}

type StudentMap = Map

struct Map {
    totalResults: u64,
    entries: Vec<T>,
}

struct RootSchema {
    students: StudentMap,
}
