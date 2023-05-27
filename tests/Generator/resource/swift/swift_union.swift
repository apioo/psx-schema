class Creature: Codable {
    var kind: String

    enum CodingKeys: String, CodingKey {
        case kind = "kind"
    }
}

class Human: Creature {
    var firstName: String

    enum CodingKeys: String, CodingKey {
        case firstName = "firstName"
    }
}

class Animal: Creature {
    var nickname: String

    enum CodingKeys: String, CodingKey {
        case nickname = "nickname"
    }
}

class Union: Codable {
    var union: Human | Animal
    var intersection: Human & Animal
    var discriminator: Human | Animal

    enum CodingKeys: String, CodingKey {
        case union = "union"
        case intersection = "intersection"
        case discriminator = "discriminator"
    }
}
