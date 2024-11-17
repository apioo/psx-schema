import {DefinitionType} from "./DefinitionType";

/**
 * TypeSchema specification
 */
export interface TypeSchema {
    definitions?: Map<string, DefinitionType>
    import?: Map<string, string>
    root?: string
}

