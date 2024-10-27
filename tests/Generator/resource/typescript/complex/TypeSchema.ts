import {DefinitionType} from "./DefinitionType";

/**
 * TypeSchema specification
 */
export interface TypeSchema {
    import?: Map<string, string>
    definitions?: Map<string, DefinitionType>
    root?: string
}

