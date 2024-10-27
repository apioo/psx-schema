import {ScalarPropertyType} from "./ScalarPropertyType";

/**
 * Represents a string value
 */
export interface StringPropertyType extends ScalarPropertyType {
    format?: string
}

