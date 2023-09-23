/**
 * Represents a base type. Every type extends from this common type and shares the defined properties
 */
open class CommonType {
    var description: String? = null
    var type: String? = null
    var nullable: Boolean? = null
    var deprecated: Boolean? = null
    var readonly: Boolean? = null
}

/**
 * Represents an any type
 */
open class AnyType : CommonType {
    var type: String? = null
}

/**
 * Represents an array type. An array type contains an ordered list of a specific type
 */
open class ArrayType : CommonType {
    var type: String? = null
    var items: Any? = null
    var maxItems: Int? = null
    var minItems: Int? = null
}

/**
 * Represents a scalar type
 */
open class ScalarType : CommonType {
    var format: String? = null
    var enum: Array<Any>? = null
    var default: Any? = null
}

/**
 * Represents a boolean type
 */
open class BooleanType : ScalarType {
    var type: String? = null
}

import java.util.HashMap;

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
open class Discriminator {
    var propertyName: String? = null
    var mapping: HashMap<String, String>? = null
}

/**
 * Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
 */
open class GenericType {
    var generic: String? = null
}

/**
 * Represents an intersection type
 */
open class IntersectionType {
    var description: String? = null
    var allOf: Array<ReferenceType>? = null
}

/**
 * Represents a map type. A map type contains variable key value entries of a specific type
 */
open class MapType : CommonType {
    var type: String? = null
    var additionalProperties: Any? = null
    var maxProperties: Int? = null
    var minProperties: Int? = null
}

/**
 * Represents a number type (contains also integer)
 */
open class NumberType : ScalarType {
    var type: String? = null
    var multipleOf: Float? = null
    var maximum: Float? = null
    var exclusiveMaximum: Boolean? = null
    var minimum: Float? = null
    var exclusiveMinimum: Boolean? = null
}

import java.util.HashMap;

/**
 * Represents a reference type. A reference type points to a specific type at the definitions map
 */
open class ReferenceType {
    var ref: String? = null
    var template: HashMap<String, String>? = null
}

/**
 * Represents a string type
 */
open class StringType : ScalarType {
    var type: String? = null
    var maxLength: Int? = null
    var minLength: Int? = null
    var pattern: String? = null
}

import java.util.HashMap;

/**
 * Represents a struct type. A struct type contains a fix set of defined properties
 */
open class StructType : CommonType {
    var final: Boolean? = null
    var extends: String? = null
    var type: String? = null
    var properties: HashMap<String, Any>? = null
    var required: Array<String>? = null
}

import java.util.HashMap;

/**
 * The root TypeSchema
 */
open class TypeSchema {
    var import: HashMap<String, String>? = null
    var definitions: HashMap<String, Any>? = null
    var ref: String? = null
}

/**
 * Represents an union type. An union type can contain one of the provided types
 */
open class UnionType {
    var description: String? = null
    var discriminator: Discriminator? = null
    var oneOf: Array<Any>? = null
}
