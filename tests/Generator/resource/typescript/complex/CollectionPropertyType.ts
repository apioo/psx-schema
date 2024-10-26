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

