// Represents a boolean value
class BooleanPropertyType: ScalarPropertyType {
    var _type: String? = "boolean"

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

