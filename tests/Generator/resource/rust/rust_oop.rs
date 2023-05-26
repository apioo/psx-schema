struct Human {
    firstName: String,
}

struct Student {
    firstName: String,
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
