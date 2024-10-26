// Represents a boolean value
class BooleanPropertyType: ScalarPropertyType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

