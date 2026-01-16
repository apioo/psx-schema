// Represents a string value
class StringPropertyType: ScalarPropertyType {
    var _default: String?
    var format: String?
    var _type: String? = "string"

    enum CodingKeys: String, CodingKey {
        case _default = "default"
        case format = "format"
        case _type = "type"
    }
}

