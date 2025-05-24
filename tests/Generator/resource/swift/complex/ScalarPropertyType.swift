// Base scalar property type
class ScalarPropertyType: PropertyType {
    var _type: String?

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

