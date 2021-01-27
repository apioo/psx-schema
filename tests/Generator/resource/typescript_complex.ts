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

export type PropertyValue = BooleanType | NumberType | StringType | ArrayType | CombinationType | ReferenceType | GenericType;

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

import {Properties} from "./Properties";
import {StringArray} from "./StringArray";

export interface StructProperties {
    properties: Properties
    required?: StringArray
}

export type StructType = CommonProperties & ContainerProperties & StructProperties;

/**
 * Map specific properties
 */

import {PropertyValue} from "./PropertyValue";
import {PositiveInteger} from "./PositiveInteger";

export interface MapProperties {
    additionalProperties: PropertyValue
    maxProperties?: number
    minProperties?: number
}

export type MapType = CommonProperties & ContainerProperties & MapProperties;

export type ObjectType = StructType | MapType;

export type ArrayValue = BooleanType | NumberType | StringType | ReferenceType | GenericType;

/**
 * Array properties
 */

import {ArrayValue} from "./ArrayValue";
import {PositiveInteger} from "./PositiveInteger";

export interface ArrayProperties {
    type: string
    items: ArrayValue
    maxItems?: number
    minItems?: number
    uniqueItems?: boolean
}

export type ArrayType = CommonProperties & ArrayProperties;

/**
 * Boolean properties
 */


export interface BooleanProperties {
    type: string
}

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

export type NumberType = CommonProperties & ScalarProperties & NumberProperties;

/**
 * String properties
 */

import {PositiveInteger} from "./PositiveInteger";

export interface StringProperties {
    type: string
    maxLength?: number
    minLength?: number
    pattern?: string
}

export type StringType = CommonProperties & ScalarProperties & StringProperties;

export type OfValue = NumberType | StringType | BooleanType | ReferenceType;

export type DiscriminatorMapping = Record<string, string>;

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */

import {DiscriminatorMapping} from "./DiscriminatorMapping";

export interface Discriminator {
    propertyName: string
    mapping?: DiscriminatorMapping
}

/**
 * An intersection type combines multiple schemas into one
 */

import {OfValue} from "./OfValue";

export interface AllOfProperties {
    description?: string
    allOf: Array<OfValue>
}

/**
 * An union type can contain one of the provided schemas
 */

import {Discriminator} from "./Discriminator";
import {OfValue} from "./OfValue";

export interface OneOfProperties {
    description?: string
    discriminator?: Discriminator
    oneOf: Array<OfValue>
}

export type CombinationType = AllOfProperties | OneOfProperties;

export type TemplateProperties = Record<string, ReferenceType>;

/**
 * Represents a reference to another schema
 */

import {TemplateProperties} from "./TemplateProperties";

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

export type DefinitionValue = ObjectType | ArrayType | BooleanType | NumberType | StringType | CombinationType;

export type Definitions = Record<string, DefinitionValue>;

export type Import = Record<string, string>;

export type EnumValue = StringArray | NumberArray;

export type ScalarValue = string | number | boolean;

export type StringArray = Array<string>;

export type NumberArray = Array<number>;

/**
 * TypeSchema meta schema which describes a TypeSchema
 */

import {Import} from "./Import";
import {Definitions} from "./Definitions";
import {Properties} from "./Properties";
import {StringArray} from "./StringArray";

export interface TypeSchema {
    import?: Import
    title: string
    description?: string
    type: string
    definitions?: Definitions
    properties: Properties
    required?: StringArray
}
