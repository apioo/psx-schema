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


/**
 * Allowed values of an object property
 */

import {BooleanType} from "./BooleanType";
import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {ArrayType} from "./ArrayType";
import {CombinationType} from "./CombinationType";
import {ReferenceType} from "./ReferenceType";
import {GenericType} from "./GenericType";

export type PropertyValue = BooleanType | NumberType | StringType | ArrayType | CombinationType | ReferenceType | GenericType;


/**
 * Properties of a schema
 */

import {PropertyValue} from "./PropertyValue";

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


/**
 * A struct contains a fix set of defined properties
 */

import {CommonProperties} from "./CommonProperties";
import {ContainerProperties} from "./ContainerProperties";
import {StructProperties} from "./StructProperties";

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


/**
 * A map contains variable key value entries of a specific type
 */

import {CommonProperties} from "./CommonProperties";
import {ContainerProperties} from "./ContainerProperties";
import {MapProperties} from "./MapProperties";

export type MapType = CommonProperties & ContainerProperties & MapProperties;


/**
 * An object represents either a struct or map type
 */

import {StructType} from "./StructType";
import {MapType} from "./MapType";

export type ObjectType = StructType | MapType;


/**
 * Allowed values of an array item
 */

import {BooleanType} from "./BooleanType";
import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {ReferenceType} from "./ReferenceType";
import {GenericType} from "./GenericType";

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


/**
 * An array contains an ordered list of a specific type
 */

import {CommonProperties} from "./CommonProperties";
import {ArrayProperties} from "./ArrayProperties";

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

import {CommonProperties} from "./CommonProperties";
import {ScalarProperties} from "./ScalarProperties";
import {BooleanProperties} from "./BooleanProperties";

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

import {CommonProperties} from "./CommonProperties";
import {ScalarProperties} from "./ScalarProperties";
import {NumberProperties} from "./NumberProperties";

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


/**
 * Represents a string value
 */

import {CommonProperties} from "./CommonProperties";
import {ScalarProperties} from "./ScalarProperties";
import {StringProperties} from "./StringProperties";

export type StringType = CommonProperties & ScalarProperties & StringProperties;


/**
 * Allowed values in a combination schema
 */

import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {BooleanType} from "./BooleanType";
import {ReferenceType} from "./ReferenceType";

export type OfValue = NumberType | StringType | BooleanType | ReferenceType;


/**
 * An object to hold mappings between payload values and schema names or references
 */

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


/**
 * A combination type is either a intersection or union type
 */

import {AllOfProperties} from "./AllOfProperties";
import {OneOfProperties} from "./OneOfProperties";

export type CombinationType = AllOfProperties | OneOfProperties;



import {ReferenceType} from "./ReferenceType";

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


/**
 * Represents a concrete type definition
 */

import {ObjectType} from "./ObjectType";
import {ArrayType} from "./ArrayType";
import {BooleanType} from "./BooleanType";
import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {CombinationType} from "./CombinationType";

export type DefinitionValue = ObjectType | ArrayType | BooleanType | NumberType | StringType | CombinationType;


/**
 * Schema definitions which can be reused
 */

import {DefinitionValue} from "./DefinitionValue";

export type Definitions = Record<string, DefinitionValue>;


/**
 * Contains external definitions which are imported. The imported schemas can be used via the namespace
 */

export type Import = Record<string, string>;


/**
 * A list of possible enumeration values
 */

import {StringArray} from "./StringArray";
import {NumberArray} from "./NumberArray";

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

