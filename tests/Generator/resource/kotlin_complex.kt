/**
 * Common properties which can be used at any schema
 */
open class CommonProperties {
    var title: String? = null
    var description: String? = null
    var type: String? = null
    var nullable: Boolean? = null
    var deprecated: Boolean? = null
    var readonly: Boolean? = null
}

open class ScalarProperties {
    var format: String? = null
    var enum: Any? = null
    var default: Any? = null
}

import java.util.HashMap;

/**
 * Properties of a schema
 */
open class Properties : HashMap<String, PropertyValue>() {
}

/**
 * Properties specific for a container
 */
open class ContainerProperties {
    var type: String? = null
}

/**
 * Struct specific properties
 */
open class StructProperties {
    var properties: Properties? = null
    var required: Array<String>? = null
}

/**
 * Map specific properties
 */
open class MapProperties {
    var additionalProperties: Any? = null
    var maxProperties: Int? = null
    var minProperties: Int? = null
}

/**
 * Array properties
 */
open class ArrayProperties {
    var type: String? = null
    var items: Any? = null
    var maxItems: Int? = null
    var minItems: Int? = null
    var uniqueItems: Boolean? = null
}

/**
 * Boolean properties
 */
open class BooleanProperties {
    var type: String? = null
}

/**
 * Number properties
 */
open class NumberProperties {
    var type: String? = null
    var multipleOf: Float? = null
    var maximum: Float? = null
    var exclusiveMaximum: Boolean? = null
    var minimum: Float? = null
    var exclusiveMinimum: Boolean? = null
}

/**
 * String properties
 */
open class StringProperties {
    var type: String? = null
    var maxLength: Int? = null
    var minLength: Int? = null
    var pattern: String? = null
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
 * An intersection type combines multiple schemas into one
 */
open class AllOfProperties {
    var description: String? = null
    var allOf: Array<OfValue>? = null
}

/**
 * An union type can contain one of the provided schemas
 */
open class OneOfProperties {
    var description: String? = null
    var discriminator: Discriminator? = null
    var oneOf: Array<OfValue>? = null
}

import java.util.HashMap;
open class TemplateProperties : HashMap<String, ReferenceType>() {
}

/**
 * Represents a reference to another schema
 */
open class ReferenceType {
    var ref: String? = null
    var template: TemplateProperties? = null
}

/**
 * Represents a generic type
 */
open class GenericType {
    var generic: String? = null
}

import java.util.HashMap;

/**
 * Schema definitions which can be reused
 */
open class Definitions : HashMap<String, DefinitionValue>() {
}

import java.util.HashMap;

/**
 * Contains external definitions which are imported. The imported schemas can be used via the namespace
 */
open class Import : HashMap<String, String>() {
}

/**
 * TypeSchema meta schema which describes a TypeSchema
 */
open class TypeSchema {
    var import: Import? = null
    var title: String? = null
    var description: String? = null
    var type: String? = null
    var definitions: Definitions? = null
    var properties: Properties? = null
    var required: Array<String>? = null
}
