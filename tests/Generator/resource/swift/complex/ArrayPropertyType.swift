// Represents an array which contains a dynamic list of values of the same type
class ArrayPropertyType: CollectionPropertyType {
    var _type: String? = "array"

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

