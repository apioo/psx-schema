import {TypeSchema} from "./TypeSchema";
import {Security} from "./Security";
import {Operation} from "./Operation";

/**
 * The TypeAPI Root
 */
export interface TypeAPI extends TypeSchema {
    baseUrl?: string
    security?: Security
    operations?: Map<string, Operation>
}

