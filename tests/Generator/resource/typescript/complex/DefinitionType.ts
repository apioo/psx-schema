import {ArrayDefinitionType} from "./ArrayDefinitionType";
import {MapDefinitionType} from "./MapDefinitionType";
import {StructDefinitionType} from "./StructDefinitionType";

/**
 * Base definition type
 */
export interface DefinitionType {
    deprecated?: boolean
    description?: string
    type?: string
}

