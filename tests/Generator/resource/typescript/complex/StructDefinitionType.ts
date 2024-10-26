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

