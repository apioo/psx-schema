class Creature: Codable {
    var kind: String
}

class Human: Creature {
    var firstName: String
}

class Animal: Creature {
    var nickname: String
}

class Union: Codable {
    var union: Human | Animal
    var intersection: Human & Animal
    var discriminator: Human | Animal
}
