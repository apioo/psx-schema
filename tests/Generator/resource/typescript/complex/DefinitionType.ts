import type {ArrayDefinitionType} from "./ArrayDefinitionType";
import type {MapDefinitionType} from "./MapDefinitionType";
import type {StructDefinitionType} from "./StructDefinitionType";

/**
 * Base definition type
 */
export interface DefinitionType {
    deprecated?: boolean
    description?: string
    type?: string
}

