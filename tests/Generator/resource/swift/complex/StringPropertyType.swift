// Represents a string value
class StringPropertyType: ScalarPropertyType {
    var _type: String
    var format: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case format = "format"
    }
}

