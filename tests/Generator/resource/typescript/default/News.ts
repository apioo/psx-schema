import type {Meta} from "./Meta";
import type {Author} from "./Author";

/**
 * An general news entry
 */
export interface News {
    config?: Meta
    inlineConfig?: Record<string, string>
    mapTags?: Record<string, string>
    mapReceiver?: Record<string, Author>
    tags?: Array<string>
    receiver?: Array<Author>
    data?: Array<Array<number>>
    read?: boolean
    author: Author
    meta?: Meta
    sendDate?: string
    readDate?: string
    price?: number
    rating?: number
    content: string
    question?: string
    version?: string
    coffeeTime?: string
    "g-recaptcha-response"?: string
    "media.fields"?: string
    payload?: any
}

