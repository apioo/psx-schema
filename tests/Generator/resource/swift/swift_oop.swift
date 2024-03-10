class Human: Codable {
    var firstName: String
    var parent: Human

    enum CodingKeys: String, CodingKey {
        case firstName = "firstName"
        case parent = "parent"
    }
}

class Student: Human {
    var matricleNumber: String

    enum CodingKeys: String, CodingKey {
        case matricleNumber = "matricleNumber"
    }
}

typealias StudentMap = Map<Student>;

class Map: Codable {
    var totalResults: Int
    var entries: Array<T>

    enum CodingKeys: String, CodingKey {
        case totalResults = "totalResults"
        case entries = "entries"
    }
}

class RootSchema: Codable {
    var students: StudentMap

    enum CodingKeys: String, CodingKey {
        case students = "students"
    }
}
