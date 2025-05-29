import {PropertyType} from "./PropertyType";

/**
 * Describes the response of the operation
 */
export interface Response {
    code?: number
    contentType?: string
    schema?: PropertyType
}

