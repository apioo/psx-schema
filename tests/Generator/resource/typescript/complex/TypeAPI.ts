import type {TypeSchema} from "./TypeSchema";
import type {Operation} from "./Operation";
import type {Security} from "./Security";

/**
 * The TypeAPI Root
 */
export interface TypeAPI extends TypeSchema {
    baseUrl?: string
    operations?: Record<string, Operation>
    security?: Security
}

