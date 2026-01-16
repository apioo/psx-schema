// Represents a generic value which can be replaced with a concrete type
class GenericPropertyType: PropertyType {
    var name: String?
    var _type: String? = "generic"

    enum CodingKeys: String, CodingKey {
        case name = "name"
        case _type = "type"
    }
}

