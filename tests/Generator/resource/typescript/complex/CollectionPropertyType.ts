import {ArrayPropertyType} from "./ArrayPropertyType";
import {MapPropertyType} from "./MapPropertyType";
import {PropertyType} from "./PropertyType";

/**
 * Base collection property type
 */
export interface CollectionPropertyType extends PropertyType {
    schema?: PropertyType
    type?: string
}

