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
    open fun setTitle(title: String?) {
        this.title = title;
    }
    open fun getTitle(): String? {
        return this.title;
    }
    open fun setDescription(description: String?) {
        this.description = description;
    }
    open fun getDescription(): String? {
        return this.description;
    }
    open fun setType(type: String?) {
        this.type = type;
    }
    open fun getType(): String? {
        return this.type;
    }
    open fun setNullable(nullable: Boolean?) {
        this.nullable = nullable;
    }
    open fun getNullable(): Boolean? {
        return this.nullable;
    }
    open fun setDeprecated(deprecated: Boolean?) {
        this.deprecated = deprecated;
    }
    open fun getDeprecated(): Boolean? {
        return this.deprecated;
    }
    open fun setReadonly(readonly: Boolean?) {
        this.readonly = readonly;
    }
    open fun getReadonly(): Boolean? {
        return this.readonly;
    }
}

open class ScalarProperties {
    var format: String? = null
    var enum: Object? = null
    var default: Object? = null
    open fun setFormat(format: String?) {
        this.format = format;
    }
    open fun getFormat(): String? {
        return this.format;
    }
    open fun setEnum(enum: Object?) {
        this.enum = enum;
    }
    open fun getEnum(): Object? {
        return this.enum;
    }
    open fun setDefault(default: Object?) {
        this.default = default;
    }
    open fun getDefault(): Object? {
        return this.default;
    }
}

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
    open fun setType(type: String?) {
        this.type = type;
    }
    open fun getType(): String? {
        return this.type;
    }
}

/**
 * Struct specific properties
 */
open class StructProperties {
    var properties: Properties? = null
    var required: Array<String>? = null
    open fun setProperties(properties: Properties?) {
        this.properties = properties;
    }
    open fun getProperties(): Properties? {
        return this.properties;
    }
    open fun setRequired(required: Array<String>?) {
        this.required = required;
    }
    open fun getRequired(): Array<String>? {
        return this.required;
    }
}

/**
 * Map specific properties
 */
open class MapProperties {
    var additionalProperties: Object? = null
    var maxProperties: Int? = null
    var minProperties: Int? = null
    open fun setAdditionalProperties(additionalProperties: Object?) {
        this.additionalProperties = additionalProperties;
    }
    open fun getAdditionalProperties(): Object? {
        return this.additionalProperties;
    }
    open fun setMaxProperties(maxProperties: Int?) {
        this.maxProperties = maxProperties;
    }
    open fun getMaxProperties(): Int? {
        return this.maxProperties;
    }
    open fun setMinProperties(minProperties: Int?) {
        this.minProperties = minProperties;
    }
    open fun getMinProperties(): Int? {
        return this.minProperties;
    }
}

/**
 * Array properties
 */
open class ArrayProperties {
    var type: String? = null
    var items: Object? = null
    var maxItems: Int? = null
    var minItems: Int? = null
    var uniqueItems: Boolean? = null
    open fun setType(type: String?) {
        this.type = type;
    }
    open fun getType(): String? {
        return this.type;
    }
    open fun setItems(items: Object?) {
        this.items = items;
    }
    open fun getItems(): Object? {
        return this.items;
    }
    open fun setMaxItems(maxItems: Int?) {
        this.maxItems = maxItems;
    }
    open fun getMaxItems(): Int? {
        return this.maxItems;
    }
    open fun setMinItems(minItems: Int?) {
        this.minItems = minItems;
    }
    open fun getMinItems(): Int? {
        return this.minItems;
    }
    open fun setUniqueItems(uniqueItems: Boolean?) {
        this.uniqueItems = uniqueItems;
    }
    open fun getUniqueItems(): Boolean? {
        return this.uniqueItems;
    }
}

/**
 * Boolean properties
 */
open class BooleanProperties {
    var type: String? = null
    open fun setType(type: String?) {
        this.type = type;
    }
    open fun getType(): String? {
        return this.type;
    }
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
    open fun setType(type: String?) {
        this.type = type;
    }
    open fun getType(): String? {
        return this.type;
    }
    open fun setMultipleOf(multipleOf: Float?) {
        this.multipleOf = multipleOf;
    }
    open fun getMultipleOf(): Float? {
        return this.multipleOf;
    }
    open fun setMaximum(maximum: Float?) {
        this.maximum = maximum;
    }
    open fun getMaximum(): Float? {
        return this.maximum;
    }
    open fun setExclusiveMaximum(exclusiveMaximum: Boolean?) {
        this.exclusiveMaximum = exclusiveMaximum;
    }
    open fun getExclusiveMaximum(): Boolean? {
        return this.exclusiveMaximum;
    }
    open fun setMinimum(minimum: Float?) {
        this.minimum = minimum;
    }
    open fun getMinimum(): Float? {
        return this.minimum;
    }
    open fun setExclusiveMinimum(exclusiveMinimum: Boolean?) {
        this.exclusiveMinimum = exclusiveMinimum;
    }
    open fun getExclusiveMinimum(): Boolean? {
        return this.exclusiveMinimum;
    }
}

/**
 * String properties
 */
open class StringProperties {
    var type: String? = null
    var maxLength: Int? = null
    var minLength: Int? = null
    var pattern: String? = null
    open fun setType(type: String?) {
        this.type = type;
    }
    open fun getType(): String? {
        return this.type;
    }
    open fun setMaxLength(maxLength: Int?) {
        this.maxLength = maxLength;
    }
    open fun getMaxLength(): Int? {
        return this.maxLength;
    }
    open fun setMinLength(minLength: Int?) {
        this.minLength = minLength;
    }
    open fun getMinLength(): Int? {
        return this.minLength;
    }
    open fun setPattern(pattern: String?) {
        this.pattern = pattern;
    }
    open fun getPattern(): String? {
        return this.pattern;
    }
}

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
    open fun setPropertyName(propertyName: String?) {
        this.propertyName = propertyName;
    }
    open fun getPropertyName(): String? {
        return this.propertyName;
    }
    open fun setMapping(mapping: DiscriminatorMapping?) {
        this.mapping = mapping;
    }
    open fun getMapping(): DiscriminatorMapping? {
        return this.mapping;
    }
}

/**
 * An intersection type combines multiple schemas into one
 */
open class AllOfProperties {
    var description: String? = null
    var allOf: Array<OfValue>? = null
    open fun setDescription(description: String?) {
        this.description = description;
    }
    open fun getDescription(): String? {
        return this.description;
    }
    open fun setAllOf(allOf: Array<OfValue>?) {
        this.allOf = allOf;
    }
    open fun getAllOf(): Array<OfValue>? {
        return this.allOf;
    }
}

/**
 * An union type can contain one of the provided schemas
 */
open class OneOfProperties {
    var description: String? = null
    var discriminator: Discriminator? = null
    var oneOf: Array<OfValue>? = null
    open fun setDescription(description: String?) {
        this.description = description;
    }
    open fun getDescription(): String? {
        return this.description;
    }
    open fun setDiscriminator(discriminator: Discriminator?) {
        this.discriminator = discriminator;
    }
    open fun getDiscriminator(): Discriminator? {
        return this.discriminator;
    }
    open fun setOneOf(oneOf: Array<OfValue>?) {
        this.oneOf = oneOf;
    }
    open fun getOneOf(): Array<OfValue>? {
        return this.oneOf;
    }
}

open class TemplateProperties : HashMap<String, ReferenceType>() {
}

/**
 * Represents a reference to another schema
 */
open class ReferenceType {
    var ref: String? = null
    var template: TemplateProperties? = null
    open fun setRef(ref: String?) {
        this.ref = ref;
    }
    open fun getRef(): String? {
        return this.ref;
    }
    open fun setTemplate(template: TemplateProperties?) {
        this.template = template;
    }
    open fun getTemplate(): TemplateProperties? {
        return this.template;
    }
}

/**
 * Represents a generic type
 */
open class GenericType {
    var generic: String? = null
    open fun setGeneric(generic: String?) {
        this.generic = generic;
    }
    open fun getGeneric(): String? {
        return this.generic;
    }
}

/**
 * Schema definitions which can be reused
 */
open class Definitions : HashMap<String, DefinitionValue>() {
}

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
    open fun setImport(import: Import?) {
        this.import = import;
    }
    open fun getImport(): Import? {
        return this.import;
    }
    open fun setTitle(title: String?) {
        this.title = title;
    }
    open fun getTitle(): String? {
        return this.title;
    }
    open fun setDescription(description: String?) {
        this.description = description;
    }
    open fun getDescription(): String? {
        return this.description;
    }
    open fun setType(type: String?) {
        this.type = type;
    }
    open fun getType(): String? {
        return this.type;
    }
    open fun setDefinitions(definitions: Definitions?) {
        this.definitions = definitions;
    }
    open fun getDefinitions(): Definitions? {
        return this.definitions;
    }
    open fun setProperties(properties: Properties?) {
        this.properties = properties;
    }
    open fun getProperties(): Properties? {
        return this.properties;
    }
    open fun setRequired(required: Array<String>?) {
        this.required = required;
    }
    open fun getRequired(): Array<String>? {
        return this.required;
    }
}
