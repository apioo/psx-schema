// Base collection property type
class CollectionPropertyType: PropertyType {
    var schema: PropertyType

    enum CodingKeys: String, CodingKey {
        case schema = "schema"
    }
}

