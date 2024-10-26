// Represents a reference to a definition type
class ReferencePropertyType: PropertyType {
    var _type: String
    var target: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case target = "target"
    }
}

