// Represents an integer value
class IntegerPropertyType: ScalarPropertyType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

