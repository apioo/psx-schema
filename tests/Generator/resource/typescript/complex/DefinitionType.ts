import {StructDefinitionType} from "./StructDefinitionType";
import {MapDefinitionType} from "./MapDefinitionType";
import {ArrayDefinitionType} from "./ArrayDefinitionType";

/**
 * Base definition type
 */
export interface DefinitionType {
    description?: string
    deprecated?: boolean
    type?: string
}

