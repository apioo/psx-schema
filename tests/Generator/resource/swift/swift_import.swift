class Import: Codable {
    var students: StudentMap
    var student: Student

    enum CodingKeys: String, CodingKey {
        case students = "students"
        case student = "student"
    }
}

class MyMap: Student {

    enum CodingKeys: String, CodingKey {
    }
}
