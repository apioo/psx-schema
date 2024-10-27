import {PropertyType} from "./PropertyType";

/**
 * Represents a reference to a definition type
 */
export interface ReferencePropertyType extends PropertyType {
    target?: string
    template?: Map<string, string>
}

