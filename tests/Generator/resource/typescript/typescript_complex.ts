import {StructDefinitionType} from "./StructDefinitionType";
import {MapDefinitionType} from "./MapDefinitionType";
import {ArrayDefinitionType} from "./ArrayDefinitionType";

/**
 * Base definition type
 */
export abstract class DefinitionType {
    description?: string
    deprecated?: boolean
    type?: string
}

import {DefinitionType} from "./DefinitionType";
import {PropertyType} from "./PropertyType";

/**
 * Represents a struct which contains a fixed set of defined properties
 */
export class StructDefinitionType extends DefinitionType {
    type?: string
    parent?: string
    base?: boolean
    properties?: Map<string, PropertyType>
    discriminator?: string
    mapping?: Map<string, string>
    template?: Map<string, string>
}

import {DefinitionType} from "./DefinitionType";
import {MapDefinitionType} from "./MapDefinitionType";
import {ArrayDefinitionType} from "./ArrayDefinitionType";
import {PropertyType} from "./PropertyType";

/**
 * Base type for the map and array collection type
 */
export abstract class CollectionDefinitionType extends DefinitionType {
    type?: string
    schema?: PropertyType
}

import {CollectionDefinitionType} from "./CollectionDefinitionType";

/**
 * Represents a map which contains a dynamic set of key value entries
 */
export class MapDefinitionType extends CollectionDefinitionType {
    type?: string
}

import {CollectionDefinitionType} from "./CollectionDefinitionType";

/**
 * Represents an array which contains a dynamic list of values
 */
export class ArrayDefinitionType extends CollectionDefinitionType {
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
export abstract class PropertyType {
    description?: string
    deprecated?: boolean
    type?: string
    nullable?: boolean
}

import {PropertyType} from "./PropertyType";
import {IntegerPropertyType} from "./IntegerPropertyType";
import {NumberPropertyType} from "./NumberPropertyType";
import {StringPropertyType} from "./StringPropertyType";
import {BooleanPropertyType} from "./BooleanPropertyType";

/**
 * Base scalar property type
 */
export abstract class ScalarPropertyType extends PropertyType {
    type?: string
}

import {ScalarPropertyType} from "./ScalarPropertyType";

/**
 * Represents an integer value
 */
export class IntegerPropertyType extends ScalarPropertyType {
    type?: string
}

import {ScalarPropertyType} from "./ScalarPropertyType";

/**
 * Represents a float value
 */
export class NumberPropertyType extends ScalarPropertyType {
    type?: string
}

import {ScalarPropertyType} from "./ScalarPropertyType";

/**
 * Represents a string value
 */
export class StringPropertyType extends ScalarPropertyType {
    type?: string
    format?: string
}

import {ScalarPropertyType} from "./ScalarPropertyType";

/**
 * Represents a boolean value
 */
export class BooleanPropertyType extends ScalarPropertyType {
    type?: string
}

import {PropertyType} from "./PropertyType";
import {MapPropertyType} from "./MapPropertyType";
import {ArrayPropertyType} from "./ArrayPropertyType";

/**
 * Base collection property type
 */
export abstract class CollectionPropertyType extends PropertyType {
    type?: string
    schema?: PropertyType
}

import {CollectionPropertyType} from "./CollectionPropertyType";

/**
 * Represents a map which contains a dynamic set of key value entries
 */
export class MapPropertyType extends CollectionPropertyType {
    type?: string
}

import {CollectionPropertyType} from "./CollectionPropertyType";

/**
 * Represents an array which contains a dynamic list of values
 */
export class ArrayPropertyType extends CollectionPropertyType {
    type?: string
}

import {PropertyType} from "./PropertyType";

/**
 * Represents an any value which allows any kind of value
 */
export class AnyPropertyType extends PropertyType {
    type?: string
}

import {PropertyType} from "./PropertyType";

/**
 * Represents a generic value which can be replaced with a dynamic type
 */
export class GenericPropertyType extends PropertyType {
    type?: string
    name?: string
}

import {PropertyType} from "./PropertyType";

/**
 * Represents a reference to a definition type
 */
export class ReferencePropertyType extends PropertyType {
    type?: string
    target?: string
}

import {DefinitionType} from "./DefinitionType";
export class Specification {
    import?: Map<string, string>
    definitions?: Map<string, DefinitionType>
    root?: string
}
