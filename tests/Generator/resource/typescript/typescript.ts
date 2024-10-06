/**
 * Location of the person
 */
export class Location {
    lat?: number
    long?: number
}

/**
 * An application
 */
export class Web {
    name?: string
    url?: string
}

import {Location} from "./Location";

/**
 * An simple author element with some description
 */
export class Author {
    title?: string
    email?: string
    categories?: Array<string>
    locations?: Array<Location>
    origin?: Location
}

export class Meta extends Map<string, string> {
}

import {Meta} from "./Meta";
import {Author} from "./Author";

/**
 * An general news entry
 */
export class News {
    config?: Meta
    inlineConfig?: Map<string, string>
    mapTags?: Map<string, string>
    mapReceiver?: Map<string, Author>
    tags?: Array<string>
    receiver?: Array<Author>
    read?: boolean
    author?: Author
    meta?: Meta
    sendDate?: string
    readDate?: string
    price?: number
    rating?: number
    content?: string
    question?: string
    version?: string
    coffeeTime?: string
    "g-recaptcha-response"?: string
    "media.fields"?: string
    payload?: any
}
