// Represents a reference to a definition type
class ReferencePropertyType: PropertyType {
    var target: String?
    var template: Dictionary<String, String>?

    enum CodingKeys: String, CodingKey {
        case target = "target"
        case template = "template"
    }
}

