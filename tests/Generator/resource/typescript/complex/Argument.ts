import {PropertyType} from "./PropertyType";

export interface Argument {
    in?: string
    schema?: PropertyType
    contentType?: string
    name?: string
}

