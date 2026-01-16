import type {ScalarPropertyType} from "./ScalarPropertyType";

/**
 * Represents a string value
 */
export interface StringPropertyType extends ScalarPropertyType {
    type: "string"
    default?: string
    format?: string
}

