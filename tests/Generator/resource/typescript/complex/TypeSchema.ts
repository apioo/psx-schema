import type {DefinitionType} from "./DefinitionType";
import type {ArrayDefinitionType} from "./ArrayDefinitionType";
import type {MapDefinitionType} from "./MapDefinitionType";
import type {StructDefinitionType} from "./StructDefinitionType";

/**
 * TypeSchema specification
 */
export interface TypeSchema {
    definitions?: Record<string, ArrayDefinitionType|MapDefinitionType|StructDefinitionType>
    import?: Record<string, string>
    root?: string
}

