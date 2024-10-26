import {MapDefinitionType} from "./MapDefinitionType";
import {ArrayDefinitionType} from "./ArrayDefinitionType";
import {DefinitionType} from "./DefinitionType";
import {PropertyType} from "./PropertyType";

/**
 * Base type for the map and array collection type
 */
export interface CollectionDefinitionType extends DefinitionType {
    type?: string
    schema?: PropertyType
}

