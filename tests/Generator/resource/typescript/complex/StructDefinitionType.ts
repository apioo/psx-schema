import {DefinitionType} from "./DefinitionType";
import {ReferencePropertyType} from "./ReferencePropertyType";
import {PropertyType} from "./PropertyType";

/**
 * A struct represents a class/structure with a fix set of defined properties.
 */
export interface StructDefinitionType extends DefinitionType {
    base?: boolean
    discriminator?: string
    mapping?: Record<string, string>
    parent?: ReferencePropertyType
    properties?: Record<string, PropertyType>
}

