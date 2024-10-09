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

class Map<P, T>: Codable {
    var totalResults: Int
    var parent: P
    var entries: Array<T>

    enum CodingKeys: String, CodingKey {
        case totalResults = "totalResults"
        case parent = "parent"
        case entries = "entries"
    }
}

class StudentMap: Map<Human, Student> {

    enum CodingKeys: String, CodingKey {
    }
}

class HumanMap: Map<Human, Human> {

    enum CodingKeys: String, CodingKey {
    }
}

class RootSchema: Codable {
    var students: StudentMap

    enum CodingKeys: String, CodingKey {
        case students = "students"
    }
}
