/**
 * Represents a base type. Every type extends from this common type and shares the defined properties
 */
export interface CommonType {
    description?: string
    type?: string
    nullable?: boolean
    deprecated?: boolean
    readonly?: boolean
}

import {CommonType} from "./CommonType";

/**
 * Represents an any type
 */
export interface AnyType extends CommonType {
    type?: string
}

import {CommonType} from "./CommonType";
import {BooleanType} from "./BooleanType";
import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {ReferenceType} from "./ReferenceType";
import {GenericType} from "./GenericType";
import {AnyType} from "./AnyType";

/**
 * Represents an array type. An array type contains an ordered list of a specific type
 */
export interface ArrayType extends CommonType {
    type?: string
    items?: BooleanType | NumberType | StringType | ReferenceType | GenericType | AnyType
    maxItems?: number
    minItems?: number
}

import {CommonType} from "./CommonType";

/**
 * Represents a scalar type
 */
export interface ScalarType extends CommonType {
    format?: string
    enum?: Array<string | number>
    default?: string | number | boolean
}

import {ScalarType} from "./ScalarType";

/**
 * Represents a boolean type
 */
export interface BooleanType extends ScalarType {
    type?: string
}

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
export interface Discriminator {
    propertyName?: string
    mapping?: Record<string, string>
}

/**
 * Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
 */
export interface GenericType {
    $generic?: string
}

import {ReferenceType} from "./ReferenceType";

/**
 * Represents an intersection type
 */
export interface IntersectionType {
    description?: string
    allOf?: Array<ReferenceType>
}

import {CommonType} from "./CommonType";
import {BooleanType} from "./BooleanType";
import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {ArrayType} from "./ArrayType";
import {UnionType} from "./UnionType";
import {IntersectionType} from "./IntersectionType";
import {ReferenceType} from "./ReferenceType";
import {GenericType} from "./GenericType";
import {AnyType} from "./AnyType";

/**
 * Represents a map type. A map type contains variable key value entries of a specific type
 */
export interface MapType extends CommonType {
    type?: string
    additionalProperties?: BooleanType | NumberType | StringType | ArrayType | UnionType | IntersectionType | ReferenceType | GenericType | AnyType
    maxProperties?: number
    minProperties?: number
}

import {ScalarType} from "./ScalarType";

/**
 * Represents a number type (contains also integer)
 */
export interface NumberType extends ScalarType {
    type?: string
    multipleOf?: number
    maximum?: number
    exclusiveMaximum?: boolean
    minimum?: number
    exclusiveMinimum?: boolean
}

/**
 * Represents a reference type. A reference type points to a specific type at the definitions map
 */
export interface ReferenceType {
    $ref?: string
    $template?: Record<string, string>
}

import {ScalarType} from "./ScalarType";

/**
 * Represents a string type
 */
export interface StringType extends ScalarType {
    type?: string
    maxLength?: number
    minLength?: number
    pattern?: string
}

import {CommonType} from "./CommonType";
import {MapType} from "./MapType";
import {ArrayType} from "./ArrayType";
import {BooleanType} from "./BooleanType";
import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {AnyType} from "./AnyType";
import {IntersectionType} from "./IntersectionType";
import {UnionType} from "./UnionType";
import {ReferenceType} from "./ReferenceType";
import {GenericType} from "./GenericType";

/**
 * Represents a struct type. A struct type contains a fix set of defined properties
 */
export interface StructType extends CommonType {
    $final?: boolean
    $extends?: string
    type?: string
    properties?: Record<string, MapType | ArrayType | BooleanType | NumberType | StringType | AnyType | IntersectionType | UnionType | ReferenceType | GenericType>
    required?: Array<string>
}

import {StructType} from "./StructType";
import {MapType} from "./MapType";
import {ReferenceType} from "./ReferenceType";

/**
 * The root TypeSchema
 */
export interface TypeSchema {
    $import?: Record<string, string>
    definitions?: Record<string, StructType | MapType | ReferenceType>
    $ref?: string
}

import {Discriminator} from "./Discriminator";
import {NumberType} from "./NumberType";
import {StringType} from "./StringType";
import {BooleanType} from "./BooleanType";
import {ReferenceType} from "./ReferenceType";

/**
 * Represents an union type. An union type can contain one of the provided types
 */
export interface UnionType {
    description?: string
    discriminator?: Discriminator
    oneOf?: Array<NumberType | StringType | BooleanType | ReferenceType>
}
