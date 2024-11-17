import {ArrayDefinitionType} from "./ArrayDefinitionType";
import {MapDefinitionType} from "./MapDefinitionType";
import {DefinitionType} from "./DefinitionType";
import {PropertyType} from "./PropertyType";

/**
 * Base collection type
 */
export interface CollectionDefinitionType extends DefinitionType {
    schema?: PropertyType
    type?: string
}

