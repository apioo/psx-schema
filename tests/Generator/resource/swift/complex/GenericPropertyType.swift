// Represents a generic value which can be replaced with a dynamic type
class GenericPropertyType: PropertyType {
    var name: String?

    enum CodingKeys: String, CodingKey {
        case name = "name"
    }
}

