/**
 * Common properties which can be used at any schema
 */
export interface CommonProperties {
    title?: string
    description?: string
    type?: string
    nullable?: boolean
    deprecated?: boolean
    readonly?: boolean
}

import {EnumValue} from "./EnumValue";
import {ScalarValue} from "./ScalarValue";
import {BooleanType} from "./BooleanType";
import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {ArrayType} from "./ArrayType";
import {CombinationType} from "./CombinationType";
import {ReferenceType} from "./ReferenceType";
import {GenericType} from "./GenericType";
import {PropertyValue} from "./PropertyValue";
import {Properties} from "./Properties";
import {StringArray} from "./StringArray";
import {CommonProperties} from "./CommonProperties";
import {ContainerProperties} from "./ContainerProperties";
import {StructProperties} from "./StructProperties";
import {MapProperties} from "./MapProperties";
import {StructType} from "./StructType";
import {MapType} from "./MapType";
import {ArrayValue} from "./ArrayValue";
import {ArrayProperties} from "./ArrayProperties";
import {ScalarProperties} from "./ScalarProperties";
import {BooleanProperties} from "./BooleanProperties";
import {NumberProperties} from "./NumberProperties";
import {StringProperties} from "./StringProperties";
import {DiscriminatorMapping} from "./DiscriminatorMapping";
import {OfValue} from "./OfValue";
import {Discriminator} from "./Discriminator";
import {AllOfProperties} from "./AllOfProperties";
import {OneOfProperties} from "./OneOfProperties";
import {TemplateProperties} from "./TemplateProperties";
import {ObjectType} from "./ObjectType";
import {DefinitionValue} from "./DefinitionValue";
import {NumberArray} from "./NumberArray";
import {Import} from "./Import";
import {Definitions} from "./Definitions";

export interface ScalarProperties {
    format?: string
    enum?: EnumValue
    default?: ScalarValue
}

/**
 * Allowed values of an object property
 */
export type PropertyValue = BooleanType | NumberType | StringType | ArrayType | CombinationType | ReferenceType | GenericType;

/**
 * Properties of a schema
 */
export type Properties = Record<string, PropertyValue>;

/**
 * Properties specific for a container
 */
export interface ContainerProperties {
    type: string
}

/**
 * Struct specific properties
 */
export interface StructProperties {
    properties: Properties
    required?: StringArray
}

/**
 * A struct contains a fix set of defined properties
 */
export type StructType = CommonProperties & ContainerProperties & StructProperties;

/**
 * Map specific properties
 */
export interface MapProperties {
    additionalProperties: PropertyValue
    maxProperties?: number
    minProperties?: number
}

/**
 * A map contains variable key value entries of a specific type
 */
export type MapType = CommonProperties & ContainerProperties & MapProperties;

/**
 * An object represents either a struct or map type
 */
export type ObjectType = StructType | MapType;

/**
 * Allowed values of an array item
 */
export type ArrayValue = BooleanType | NumberType | StringType | ReferenceType | GenericType;

/**
 * Array properties
 */
export interface ArrayProperties {
    type: string
    items: ArrayValue
    maxItems?: number
    minItems?: number
    uniqueItems?: boolean
}

/**
 * An array contains an ordered list of a specific type
 */
export type ArrayType = CommonProperties & ArrayProperties;

/**
 * Boolean properties
 */
export interface BooleanProperties {
    type: string
}

/**
 * Represents a boolean value
 */
export type BooleanType = CommonProperties & ScalarProperties & BooleanProperties;

/**
 * Number properties
 */
export interface NumberProperties {
    type: string
    multipleOf?: number
    maximum?: number
    exclusiveMaximum?: boolean
    minimum?: number
    exclusiveMinimum?: boolean
}

/**
 * Represents a number value (contains also integer)
 */
export type NumberType = CommonProperties & ScalarProperties & NumberProperties;

/**
 * String properties
 */
export interface StringProperties {
    type: string
    maxLength?: number
    minLength?: number
    pattern?: string
}

/**
 * Represents a string value
 */
export type StringType = CommonProperties & ScalarProperties & StringProperties;

/**
 * Allowed values in a combination schema
 */
export type OfValue = NumberType | StringType | BooleanType | ReferenceType;

/**
 * An object to hold mappings between payload values and schema names or references
 */
export type DiscriminatorMapping = Record<string, string>;

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
export interface Discriminator {
    propertyName: string
    mapping?: DiscriminatorMapping
}

/**
 * An intersection type combines multiple schemas into one
 */
export interface AllOfProperties {
    description?: string
    allOf: Array<OfValue>
}

/**
 * An union type can contain one of the provided schemas
 */
export interface OneOfProperties {
    description?: string
    discriminator?: Discriminator
    oneOf: Array<OfValue>
}

/**
 * A combination type is either a intersection or union type
 */
export type CombinationType = AllOfProperties | OneOfProperties;

export type TemplateProperties = Record<string, ReferenceType>;

/**
 * Represents a reference to another schema
 */
export interface ReferenceType {
    ref: string
    template?: TemplateProperties
}

/**
 * Represents a generic type
 */
export interface GenericType {
    generic: string
}

/**
 * Represents a concrete type definition
 */
export type DefinitionValue = ObjectType | ArrayType | BooleanType | NumberType | StringType | CombinationType;

/**
 * Schema definitions which can be reused
 */
export type Definitions = Record<string, DefinitionValue>;

/**
 * Contains external definitions which are imported. The imported schemas can be used via the namespace
 */
export type Import = Record<string, string>;

/**
 * A list of possible enumeration values
 */
export type EnumValue = StringArray | NumberArray;

/**
 * Represents a scalar value
 */
export type ScalarValue = string | number | boolean;

/**
 * Array string values
 */
export type StringArray = Array<string>;

/**
 * Array number values
 */
export type NumberArray = Array<number>;

/**
 * TypeSchema meta schema which describes a TypeSchema
 */
export interface TypeSchema {
    import?: Import
    title: string
    description?: string
    type: string
    definitions?: Definitions
    properties: Properties
    required?: StringArray
}
