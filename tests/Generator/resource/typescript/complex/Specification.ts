import {DefinitionType} from "./DefinitionType";

export interface Specification {
    import?: Map<string, string>
    definitions?: Map<string, DefinitionType>
    root?: string
}

