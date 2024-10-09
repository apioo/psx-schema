/**
 * Base definition type
 */
open abstract class DefinitionType {
    var description: String? = null
    var deprecated: Boolean? = null
    var type: String? = null
}

/**
 * Represents a struct which contains a fixed set of defined properties
 */
open class StructDefinitionType : DefinitionType {
    var type: String? = null
    var parent: String? = null
    var base: Boolean? = null
    var properties: Map<String, PropertyType>? = null
    var discriminator: String? = null
    var mapping: Map<String, String>? = null
    var template: Map<String, String>? = null
}

/**
 * Base type for the map and array collection type
 */
open abstract class CollectionDefinitionType : DefinitionType {
    var type: String? = null
    var schema: PropertyType? = null
}

/**
 * Represents a map which contains a dynamic set of key value entries
 */
open class MapDefinitionType : CollectionDefinitionType {
    var type: String? = null
}

/**
 * Represents an array which contains a dynamic list of values
 */
open class ArrayDefinitionType : CollectionDefinitionType {
    var type: String? = null
}

/**
 * Base property type
 */
open abstract class PropertyType {
    var description: String? = null
    var deprecated: Boolean? = null
    var type: String? = null
    var nullable: Boolean? = null
}

/**
 * Base scalar property type
 */
open abstract class ScalarPropertyType : PropertyType {
    var type: String? = null
}

/**
 * Represents an integer value
 */
open class IntegerPropertyType : ScalarPropertyType {
    var type: String? = null
}

/**
 * Represents a float value
 */
open class NumberPropertyType : ScalarPropertyType {
    var type: String? = null
}

/**
 * Represents a string value
 */
open class StringPropertyType : ScalarPropertyType {
    var type: String? = null
    var format: String? = null
}

/**
 * Represents a boolean value
 */
open class BooleanPropertyType : ScalarPropertyType {
    var type: String? = null
}

/**
 * Base collection property type
 */
open abstract class CollectionPropertyType : PropertyType {
    var type: String? = null
    var schema: PropertyType? = null
}

/**
 * Represents a map which contains a dynamic set of key value entries
 */
open class MapPropertyType : CollectionPropertyType {
    var type: String? = null
}

/**
 * Represents an array which contains a dynamic list of values
 */
open class ArrayPropertyType : CollectionPropertyType {
    var type: String? = null
}

/**
 * Represents an any value which allows any kind of value
 */
open class AnyPropertyType : PropertyType {
    var type: String? = null
}

/**
 * Represents a generic value which can be replaced with a dynamic type
 */
open class GenericPropertyType : PropertyType {
    var type: String? = null
    var name: String? = null
}

/**
 * Represents a reference to a definition type
 */
open class ReferencePropertyType : PropertyType {
    var type: String? = null
    var target: String? = null
}

open class Specification {
    var import: Map<String, String>? = null
    var definitions: Map<String, DefinitionType>? = null
    var root: String? = null
}
