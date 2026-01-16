// Represents a reference to a definition type
class ReferencePropertyType: PropertyType {
    var target: String?
    var template: Dictionary<String, String>?
    var _type: String? = "reference"

    enum CodingKeys: String, CodingKey {
        case target = "target"
        case template = "template"
        case _type = "type"
    }
}

