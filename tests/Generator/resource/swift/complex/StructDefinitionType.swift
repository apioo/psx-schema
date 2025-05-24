// A struct represents a class/structure with a fix set of defined properties.
class StructDefinitionType: DefinitionType {
    var base: Bool?
    var discriminator: String?
    var mapping: Dictionary<String, String>?
    var parent: ReferencePropertyType?
    var properties: Dictionary<String, PropertyType>?

    enum CodingKeys: String, CodingKey {
        case base = "base"
        case discriminator = "discriminator"
        case mapping = "mapping"
        case parent = "parent"
        case properties = "properties"
    }
}

