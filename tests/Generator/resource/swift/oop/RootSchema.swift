class RootSchema: Codable {
    var students: StudentMap?

    enum CodingKeys: String, CodingKey {
        case students = "students"
    }
}

