// Base collection property type
class CollectionPropertyType: PropertyType {
    var schema: PropertyType?
    var _type: String?

    enum CodingKeys: String, CodingKey {
        case schema = "schema"
        case _type = "type"
    }
}

