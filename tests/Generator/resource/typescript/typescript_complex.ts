import {StructDefinitionType} from "./StructDefinitionType";
import {MapDefinitionType} from "./MapDefinitionType";
import {ArrayDefinitionType} from "./ArrayDefinitionType";

/**
 * Base definition type
 */
export interface DefinitionType {
    description?: string
    deprecated?: boolean
    type?: string
}

import {DefinitionType} from "./DefinitionType";
import {PropertyType} from "./PropertyType";

/**
 * Represents a struct which contains a fixed set of defined properties
 */
export interface StructDefinitionType extends DefinitionType {
    type?: string
    parent?: string
    base?: boolean
    properties?: Map<string, PropertyType>
    discriminator?: string
    mapping?: Map<string, string>
    template?: Map<string, string>
}

import {MapDefinitionType} from "./MapDefinitionType";
import {ArrayDefinitionType} from "./ArrayDefinitionType";
import {DefinitionType} from "./DefinitionType";
import {PropertyType} from "./PropertyType";

/**
 * Base type for the map and array collection type
 */
export interface CollectionDefinitionType extends DefinitionType {
    type?: string
    schema?: PropertyType
}

import {CollectionDefinitionType} from "./CollectionDefinitionType";

/**
 * Represents a map which contains a dynamic set of key value entries
 */
export interface MapDefinitionType extends CollectionDefinitionType {
    type?: string
}

import {CollectionDefinitionType} from "./CollectionDefinitionType";

/**
 * Represents an array which contains a dynamic list of values
 */
export interface ArrayDefinitionType extends CollectionDefinitionType {
    type?: string
}

import {IntegerPropertyType} from "./IntegerPropertyType";
import {NumberPropertyType} from "./NumberPropertyType";
import {StringPropertyType} from "./StringPropertyType";
import {BooleanPropertyType} from "./BooleanPropertyType";
import {MapPropertyType} from "./MapPropertyType";
import {ArrayPropertyType} from "./ArrayPropertyType";
import {AnyPropertyType} from "./AnyPropertyType";
import {GenericPropertyType} from "./GenericPropertyType";
import {ReferencePropertyType} from "./ReferencePropertyType";

/**
 * Base property type
 */
export interface PropertyType {
    description?: string
    deprecated?: boolean
    type?: string
    nullable?: boolean
}

import {IntegerPropertyType} from "./IntegerPropertyType";
import {NumberPropertyType} from "./NumberPropertyType";
import {StringPropertyType} from "./StringPropertyType";
import {BooleanPropertyType} from "./BooleanPropertyType";
import {PropertyType} from "./PropertyType";

/**
 * Base scalar property type
 */
export interface ScalarPropertyType extends PropertyType {
    type?: string
}

import {ScalarPropertyType} from "./ScalarPropertyType";

/**
 * Represents an integer value
 */
export interface IntegerPropertyType extends ScalarPropertyType {
    type?: string
}

import {ScalarPropertyType} from "./ScalarPropertyType";

/**
 * Represents a float value
 */
export interface NumberPropertyType extends ScalarPropertyType {
    type?: string
}

import {ScalarPropertyType} from "./ScalarPropertyType";

/**
 * Represents a string value
 */
export interface StringPropertyType extends ScalarPropertyType {
    type?: string
    format?: string
}

import {ScalarPropertyType} from "./ScalarPropertyType";

/**
 * Represents a boolean value
 */
export interface BooleanPropertyType extends ScalarPropertyType {
    type?: string
}

import {MapPropertyType} from "./MapPropertyType";
import {ArrayPropertyType} from "./ArrayPropertyType";
import {PropertyType} from "./PropertyType";

/**
 * Base collection property type
 */
export interface CollectionPropertyType extends PropertyType {
    type?: string
    schema?: PropertyType
}

import {CollectionPropertyType} from "./CollectionPropertyType";

/**
 * Represents a map which contains a dynamic set of key value entries
 */
export interface MapPropertyType extends CollectionPropertyType {
    type?: string
}

import {CollectionPropertyType} from "./CollectionPropertyType";

/**
 * Represents an array which contains a dynamic list of values
 */
export interface ArrayPropertyType extends CollectionPropertyType {
    type?: string
}

import {PropertyType} from "./PropertyType";

/**
 * Represents an any value which allows any kind of value
 */
export interface AnyPropertyType extends PropertyType {
    type?: string
}

import {PropertyType} from "./PropertyType";

/**
 * Represents a generic value which can be replaced with a dynamic type
 */
export interface GenericPropertyType extends PropertyType {
    type?: string
    name?: string
}

import {PropertyType} from "./PropertyType";

/**
 * Represents a reference to a definition type
 */
export interface ReferencePropertyType extends PropertyType {
    type?: string
    target?: string
}

import {DefinitionType} from "./DefinitionType";
export interface Specification {
    import?: Map<string, string>
    definitions?: Map<string, DefinitionType>
    root?: string
}
