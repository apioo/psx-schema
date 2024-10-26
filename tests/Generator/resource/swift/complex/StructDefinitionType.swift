// Represents a struct which contains a fixed set of defined properties
class StructDefinitionType: DefinitionType {
    var _type: String
    var parent: String
    var base: Bool
    var properties: Dictionary<String, PropertyType>
    var discriminator: String
    var mapping: Dictionary<String, String>
    var template: Dictionary<String, String>

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case parent = "parent"
        case base = "base"
        case properties = "properties"
        case discriminator = "discriminator"
        case mapping = "mapping"
        case template = "template"
    }
}

