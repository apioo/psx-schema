import {PropertyType} from "./PropertyType";

/**
 * Base collection property type
 */
export interface CollectionPropertyType extends PropertyType {
    schema?: PropertyType
}

