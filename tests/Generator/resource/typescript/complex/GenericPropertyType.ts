import type {PropertyType} from "./PropertyType";

/**
 * Represents a generic value which can be replaced with a concrete type
 */
export interface GenericPropertyType extends PropertyType {
    type: "generic"
    name?: string
}

