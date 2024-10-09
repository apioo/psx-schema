// Base definition type
class DefinitionType: Codable {
    var description: String
    var deprecated: Bool
    var _type: String

    enum CodingKeys: String, CodingKey {
        case description = "description"
        case deprecated = "deprecated"
        case _type = "type"
    }
}

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

// Base type for the map and array collection type
class CollectionDefinitionType: DefinitionType {
    var _type: String
    var schema: PropertyType

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case schema = "schema"
    }
}

// Represents a map which contains a dynamic set of key value entries
class MapDefinitionType: CollectionDefinitionType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

// Represents an array which contains a dynamic list of values
class ArrayDefinitionType: CollectionDefinitionType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

// Base property type
class PropertyType: Codable {
    var description: String
    var deprecated: Bool
    var _type: String
    var nullable: Bool

    enum CodingKeys: String, CodingKey {
        case description = "description"
        case deprecated = "deprecated"
        case _type = "type"
        case nullable = "nullable"
    }
}

// Base scalar property type
class ScalarPropertyType: PropertyType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

// Represents an integer value
class IntegerPropertyType: ScalarPropertyType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

// Represents a float value
class NumberPropertyType: ScalarPropertyType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

// Represents a string value
class StringPropertyType: ScalarPropertyType {
    var _type: String
    var format: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case format = "format"
    }
}

// Represents a boolean value
class BooleanPropertyType: ScalarPropertyType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

// Base collection property type
class CollectionPropertyType: PropertyType {
    var _type: String
    var schema: PropertyType

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case schema = "schema"
    }
}

// Represents a map which contains a dynamic set of key value entries
class MapPropertyType: CollectionPropertyType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

// Represents an array which contains a dynamic list of values
class ArrayPropertyType: CollectionPropertyType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

// Represents an any value which allows any kind of value
class AnyPropertyType: PropertyType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

// Represents a generic value which can be replaced with a dynamic type
class GenericPropertyType: PropertyType {
    var _type: String
    var name: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case name = "name"
    }
}

// Represents a reference to a definition type
class ReferencePropertyType: PropertyType {
    var _type: String
    var target: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case target = "target"
    }
}

class Specification: Codable {
    var _import: Dictionary<String, String>
    var definitions: Dictionary<String, DefinitionType>
    var root: String

    enum CodingKeys: String, CodingKey {
        case _import = "import"
        case definitions = "definitions"
        case root = "root"
    }
}
