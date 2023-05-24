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
 * Represents a struct type. A struct type contains a fix set of defined properties
 */
open class StructType : CommonType {
    var final: Boolean? = null
    var extends: String? = null
    var type: String? = null
    var properties: Properties? = null
    var required: Array<String>? = null
}

import java.util.HashMap;

/**
 * Properties of a struct
 */
open class Properties : HashMap<String, Any>() {
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

/**
 * Represents a string type
 */
open class StringType : ScalarType {
    var type: String? = null
    var maxLength: Int? = null
    var minLength: Int? = null
    var pattern: String? = null
}

/**
 * Represents an any type
 */
open class AnyType : CommonType {
    var type: String? = null
}

/**
 * Represents an intersection type
 */
open class IntersectionType {
    var description: String? = null
    var allOf: Array<ReferenceType>? = null
}

/**
 * Represents an union type. An union type can contain one of the provided types
 */
open class UnionType {
    var description: String? = null
    var discriminator: Discriminator? = null
    var oneOf: Array<Any>? = null
}

import java.util.HashMap;

/**
 * An object to hold mappings between payload values and schema names or references
 */
open class DiscriminatorMapping : HashMap<String, String>() {
}

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
open class Discriminator {
    var propertyName: String? = null
    var mapping: DiscriminatorMapping? = null
}

/**
 * Represents a reference type. A reference type points to a specific type at the definitions map
 */
open class ReferenceType {
    var ref: String? = null
    var template: TemplateProperties? = null
}

import java.util.HashMap;
open class TemplateProperties : HashMap<String, String>() {
}

/**
 * Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
 */
open class GenericType {
    var generic: String? = null
}

import java.util.HashMap;

/**
 * The definitions map which contains all types
 */
open class Definitions : HashMap<String, Any>() {
}

import java.util.HashMap;

/**
 * Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. 'my_namespace:my_type'
 */
open class Import : HashMap<String, String>() {
}

/**
 * The root TypeSchema
 */
open class TypeSchema {
    var import: Import? = null
    var definitions: Definitions? = null
    var ref: String? = null
}
