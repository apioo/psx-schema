// Represents a generic value which can be replaced with a dynamic type
class GenericPropertyType: PropertyType {
    var _type: String
    var name: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case name = "name"
    }
}

