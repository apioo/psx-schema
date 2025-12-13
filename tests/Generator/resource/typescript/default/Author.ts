import type {Location} from "./Location";

/**
 * An simple author element with some description
 */
export interface Author {
    title: string
    email?: string
    categories?: Array<string>
    locations?: Array<Location>
    origin?: Location
}

