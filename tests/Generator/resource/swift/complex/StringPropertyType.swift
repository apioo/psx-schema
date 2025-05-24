// Represents a string value
class StringPropertyType: ScalarPropertyType {
    var format: String?

    enum CodingKeys: String, CodingKey {
        case format = "format"
    }
}

