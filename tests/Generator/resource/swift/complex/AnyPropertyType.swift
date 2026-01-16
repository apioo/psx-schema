// Represents an any value which allows any kind of value
class AnyPropertyType: PropertyType {
    var _type: String? = "any"

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

