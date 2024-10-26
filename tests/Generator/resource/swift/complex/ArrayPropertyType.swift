// Represents an array which contains a dynamic list of values
class ArrayPropertyType: CollectionPropertyType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

