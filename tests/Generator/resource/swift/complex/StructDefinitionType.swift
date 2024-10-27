// A struct represents a class/structure with a fix set of defined properties.
class StructDefinitionType: DefinitionType {
    var parent: ReferencePropertyType
    var base: Bool
    var properties: Dictionary<String, PropertyType>
    var discriminator: String
    var mapping: Dictionary<String, String>

    enum CodingKeys: String, CodingKey {
        case parent = "parent"
        case base = "base"
        case properties = "properties"
        case discriminator = "discriminator"
        case mapping = "mapping"
    }
}

