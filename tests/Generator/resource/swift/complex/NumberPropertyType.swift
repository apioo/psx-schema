// Represents a float value
class NumberPropertyType: ScalarPropertyType {
    var _type: String? = "number"

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

