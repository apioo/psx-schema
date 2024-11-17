import {DefinitionType} from "./DefinitionType";
import {ReferencePropertyType} from "./ReferencePropertyType";
import {PropertyType} from "./PropertyType";

/**
 * A struct represents a class/structure with a fix set of defined properties.
 */
export interface StructDefinitionType extends DefinitionType {
    base?: boolean
    discriminator?: string
    mapping?: Map<string, string>
    parent?: ReferencePropertyType
    properties?: Map<string, PropertyType>
}

