class Human: Codable {
    var firstName: String
    var parent: Human

    enum CodingKeys: String, CodingKey {
        case firstName = "firstName"
        case parent = "parent"
    }
}

