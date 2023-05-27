class Import: Codable {
    var students: My.Import.StudentMap
    var student: My.Import.Student

    enum CodingKeys: String, CodingKey {
        case students = "students"
        case student = "student"
    }
}

class MyMap: My.Import.Student {

    enum CodingKeys: String, CodingKey {
    }
}
