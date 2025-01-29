import {DefinitionType} from "./DefinitionType";

/**
 * TypeSchema specification
 */
export interface TypeSchema {
    definitions?: Record<string, DefinitionType>
    import?: Record<string, string>
    root?: string
}

