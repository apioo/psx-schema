// TypeSchema specification
class TypeSchema: Codable {
    var definitions: Dictionary<String, DefinitionType>
    var _import: Dictionary<String, String>
    var root: String

    enum CodingKeys: String, CodingKey {
        case definitions = "definitions"
        case _import = "import"
        case root = "root"
    }
}

