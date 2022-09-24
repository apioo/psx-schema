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
export interface ScalarProperties {
    format?: string
    enum?: EnumValue
    default?: ScalarValue
}

import {BooleanType} from "./BooleanType";
import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {ArrayType} from "./ArrayType";
import {CombinationType} from "./CombinationType";
import {ReferenceType} from "./ReferenceType";
import {GenericType} from "./GenericType";

/**
 * Allowed values of an object property
 */
export type PropertyValue = BooleanType | NumberType | StringType | ArrayType | CombinationType | ReferenceType | GenericType;

import {PropertyValue} from "./PropertyValue";

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

import {Properties} from "./Properties";
import {StringArray} from "./StringArray";

/**
 * Struct specific properties
 */
export interface StructProperties {
    properties: Properties
    required?: StringArray
}

import {CommonProperties} from "./CommonProperties";
import {ContainerProperties} from "./ContainerProperties";
import {StructProperties} from "./StructProperties";

/**
 * A struct contains a fix set of defined properties
 */
export type StructType = CommonProperties & ContainerProperties & StructProperties;

import {PropertyValue} from "./PropertyValue";
import {PositiveInteger} from "./PositiveInteger";

/**
 * Map specific properties
 */
export interface MapProperties {
    additionalProperties: PropertyValue
    maxProperties?: number
    minProperties?: number
}

import {CommonProperties} from "./CommonProperties";
import {ContainerProperties} from "./ContainerProperties";
import {MapProperties} from "./MapProperties";

/**
 * A map contains variable key value entries of a specific type
 */
export type MapType = CommonProperties & ContainerProperties & MapProperties;

import {StructType} from "./StructType";
import {MapType} from "./MapType";

/**
 * An object represents either a struct or map type
 */
export type ObjectType = StructType | MapType;

import {BooleanType} from "./BooleanType";
import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {ReferenceType} from "./ReferenceType";
import {GenericType} from "./GenericType";

/**
 * Allowed values of an array item
 */
export type ArrayValue = BooleanType | NumberType | StringType | ReferenceType | GenericType;

import {ArrayValue} from "./ArrayValue";
import {PositiveInteger} from "./PositiveInteger";

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

import {CommonProperties} from "./CommonProperties";
import {ArrayProperties} from "./ArrayProperties";

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

import {CommonProperties} from "./CommonProperties";
import {ScalarProperties} from "./ScalarProperties";
import {BooleanProperties} from "./BooleanProperties";

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

import {CommonProperties} from "./CommonProperties";
import {ScalarProperties} from "./ScalarProperties";
import {NumberProperties} from "./NumberProperties";

/**
 * Represents a number value (contains also integer)
 */
export type NumberType = CommonProperties & ScalarProperties & NumberProperties;

import {PositiveInteger} from "./PositiveInteger";

/**
 * String properties
 */
export interface StringProperties {
    type: string
    maxLength?: number
    minLength?: number
    pattern?: string
}

import {CommonProperties} from "./CommonProperties";
import {ScalarProperties} from "./ScalarProperties";
import {StringProperties} from "./StringProperties";

/**
 * Represents a string value
 */
export type StringType = CommonProperties & ScalarProperties & StringProperties;

import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {BooleanType} from "./BooleanType";
import {ReferenceType} from "./ReferenceType";

/**
 * Allowed values in a combination schema
 */
export type OfValue = NumberType | StringType | BooleanType | ReferenceType;

/**
 * An object to hold mappings between payload values and schema names or references
 */
export type DiscriminatorMapping = Record<string, string>;

import {DiscriminatorMapping} from "./DiscriminatorMapping";

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
export interface Discriminator {
    propertyName: string
    mapping?: DiscriminatorMapping
}

import {OfValue} from "./OfValue";

/**
 * An intersection type combines multiple schemas into one
 */
export interface AllOfProperties {
    description?: string
    allOf: Array<OfValue>
}

import {Discriminator} from "./Discriminator";
import {OfValue} from "./OfValue";

/**
 * An union type can contain one of the provided schemas
 */
export interface OneOfProperties {
    description?: string
    discriminator?: Discriminator
    oneOf: Array<OfValue>
}

import {AllOfProperties} from "./AllOfProperties";
import {OneOfProperties} from "./OneOfProperties";

/**
 * A combination type is either a intersection or union type
 */
export type CombinationType = AllOfProperties | OneOfProperties;

import {ReferenceType} from "./ReferenceType";
export type TemplateProperties = Record<string, ReferenceType>;

import {TemplateProperties} from "./TemplateProperties";

/**
 * Represents a reference to another schema
 */
export interface ReferenceType {
    $ref: string
    $template?: TemplateProperties
}

/**
 * Represents a generic type
 */
export interface GenericType {
    $generic: string
}

import {ObjectType} from "./ObjectType";
import {ArrayType} from "./ArrayType";
import {BooleanType} from "./BooleanType";
import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {CombinationType} from "./CombinationType";

/**
 * Represents a concrete type definition
 */
export type DefinitionValue = ObjectType | ArrayType | BooleanType | NumberType | StringType | CombinationType;

import {DefinitionValue} from "./DefinitionValue";

/**
 * Schema definitions which can be reused
 */
export type Definitions = Record<string, DefinitionValue>;

/**
 * Contains external definitions which are imported. The imported schemas can be used via the namespace
 */
export type Import = Record<string, string>;

import {StringArray} from "./StringArray";
import {NumberArray} from "./NumberArray";

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

import {Import} from "./Import";
import {Definitions} from "./Definitions";
import {Properties} from "./Properties";
import {StringArray} from "./StringArray";

/**
 * TypeSchema meta schema which describes a TypeSchema
 */
export interface TypeSchema {
    $import?: Import
    title: string
    description?: string
    type: string
    definitions?: Definitions
    properties: Properties
    required?: StringArray
}
