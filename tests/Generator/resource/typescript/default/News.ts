import {Meta} from "./Meta";
import {Author} from "./Author";

/**
 * An general news entry
 */
export interface News {
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

