import {MapDefinitionType} from "./MapDefinitionType";
import {ArrayDefinitionType} from "./ArrayDefinitionType";
import {DefinitionType} from "./DefinitionType";
import {PropertyType} from "./PropertyType";

/**
 * Base collection type
 */
export interface CollectionDefinitionType extends DefinitionType {
    schema?: PropertyType
}

