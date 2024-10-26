// Represents an array which contains a dynamic list of values
class ArrayDefinitionType: CollectionDefinitionType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

