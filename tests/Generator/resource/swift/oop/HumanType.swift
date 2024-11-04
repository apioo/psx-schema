class HumanType: Codable {
    var firstName: String
    var parent: HumanType

    enum CodingKeys: String, CodingKey {
        case firstName = "firstName"
        case parent = "parent"
    }
}

