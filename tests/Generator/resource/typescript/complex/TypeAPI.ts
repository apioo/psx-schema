import {TypeSchema} from "./TypeSchema";
import {Operation} from "./Operation";
import {Security} from "./Security";

/**
 * The TypeAPI Root
 */
export interface TypeAPI extends TypeSchema {
    baseUrl?: string
    operations?: Record<string, Operation>
    security?: Security
}

