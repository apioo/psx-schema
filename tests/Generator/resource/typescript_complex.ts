/**
 * TypeSchema meta schema to validate a TypeSchema
 */
interface TypeSchema {
    title: string
    description?: string
    type: string
    definitions?: Definitions
    properties: Properties
    required?: Array<string>
}

/**
 * Schema definitions which can be reused
 */
interface Definitions {
    [index: string]: (((CommonProperties & ContainerSpecificProperties) & ObjectStructSpecificProperties) | ((CommonProperties & ContainerSpecificProperties) & ObjectMapSpecificProperties)) | (CommonProperties & ArrayProperties) | ((CommonProperties & ScalarSpecificProperties) & BooleanTypeProperties) | ((CommonProperties & ScalarSpecificProperties) & NumberTypeProperties) | ((CommonProperties & ScalarSpecificProperties) & StringProperties) | (AllOfProperties | OneOfProperties)
}

/**
 * Common properties which can be used at any schema
 */
interface CommonProperties {
    title?: string
    description?: string
    type?: string
    nullable?: boolean
    deprecated?: boolean
    readonly?: boolean
}

interface ContainerSpecificProperties {
    type: string
}

interface ObjectStructSpecificProperties {
    properties: Properties
    required?: Array<string>
}

interface ObjectMapSpecificProperties {
    additionalProperties: ((CommonProperties & ScalarSpecificProperties) & BooleanTypeProperties) | ((CommonProperties & ScalarSpecificProperties) & NumberTypeProperties) | ((CommonProperties & ScalarSpecificProperties) & StringProperties) | (CommonProperties & ArrayProperties) | (AllOfProperties | OneOfProperties) | ReferenceType
    maxProperties?: number
    minProperties?: number
}

interface ArrayProperties {
    type: string
    items: ((CommonProperties & ScalarSpecificProperties) & BooleanTypeProperties) | ((CommonProperties & ScalarSpecificProperties) & NumberTypeProperties) | ((CommonProperties & ScalarSpecificProperties) & StringProperties) | (AllOfProperties | OneOfProperties) | ReferenceType
    maxItems?: number
    minItems?: number
    uniqueItems?: boolean
}

interface ScalarSpecificProperties {
    format?: string
    enum?: Array<string | number>
    default?: string | number | boolean
}

interface BooleanTypeProperties {
    type: string
}

interface NumberTypeProperties {
    type: string
    multipleOf?: number
    maximum?: number
    exclusiveMaximum?: boolean
    minimum?: number
    exclusiveMinimum?: boolean
}

interface StringProperties {
    type: string
    maxLength?: number
    minLength?: number
    pattern?: string
}

/**
 * Combination keyword to represent an intersection type
 */
interface AllOfProperties {
    description?: string
    allOf: Array<((CommonProperties & ScalarSpecificProperties) & NumberTypeProperties) | ((CommonProperties & ScalarSpecificProperties) & StringProperties) | ((CommonProperties & ScalarSpecificProperties) & BooleanTypeProperties) | ReferenceType>
}

/**
 * Combination keyword to represent an union type
 */
interface OneOfProperties {
    description?: string
    discriminator?: Discriminator
    oneOf: Array<((CommonProperties & ScalarSpecificProperties) & NumberTypeProperties) | ((CommonProperties & ScalarSpecificProperties) & StringProperties) | ((CommonProperties & ScalarSpecificProperties) & BooleanTypeProperties) | ReferenceType>
}

/**
 * Properties of a schema
 */
interface Properties {
    [index: string]: ((CommonProperties & ScalarSpecificProperties) & BooleanTypeProperties) | ((CommonProperties & ScalarSpecificProperties) & NumberTypeProperties) | ((CommonProperties & ScalarSpecificProperties) & StringProperties) | (CommonProperties & ArrayProperties) | (AllOfProperties | OneOfProperties) | ReferenceType
}

/**
 * Represents a reference to another schema
 */
interface ReferenceType {
    $ref: string
}

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
interface Discriminator {
    propertyName: string
    mapping?: DiscriminatorMapping
}

/**
 * An object to hold mappings between payload values and schema names or references
 */
interface DiscriminatorMapping {
    [index: string]: string
}
