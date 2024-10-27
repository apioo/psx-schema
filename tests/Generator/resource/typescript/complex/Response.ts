import {PropertyType} from "./PropertyType";

export interface Response {
    code?: number
    contentType?: string
    schema?: PropertyType
}

