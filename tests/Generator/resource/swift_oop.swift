class Human: Codable {
    var firstName: String
}

class Student: Human {
    var matricleNumber: String
}

typealias StudentMap = Map<Student>;

class Map: Codable {
    var totalResults: Int
    var entries: Array<T>
}

class RootSchema: Codable {
    var students: StudentMap
}
