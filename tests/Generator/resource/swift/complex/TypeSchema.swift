// TypeSchema specification
class TypeSchema: Codable {
    var _import: Dictionary<String, String>
    var definitions: Dictionary<String, DefinitionType>
    var root: String

    enum CodingKeys: String, CodingKey {
        case _import = "import"
        case definitions = "definitions"
        case root = "root"
    }
}

