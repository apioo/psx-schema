// Represents an integer value
class IntegerPropertyType: ScalarPropertyType {
    var _type: String? = "integer"

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

