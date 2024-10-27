import {DefinitionType} from "./DefinitionType";
import {ReferencePropertyType} from "./ReferencePropertyType";
import {PropertyType} from "./PropertyType";

/**
 * A struct represents a class/structure with a fix set of defined properties.
 */
export interface StructDefinitionType extends DefinitionType {
    parent?: ReferencePropertyType
    base?: boolean
    properties?: Map<string, PropertyType>
    discriminator?: string
    mapping?: Map<string, string>
}

