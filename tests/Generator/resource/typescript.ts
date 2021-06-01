/**
 * Location of the person
 */
export interface Location {
    lat: number
    long: number
}

/**
 * An application
 */
export interface Web {
    name: string
    url: string
}

import {Location} from "./Location";

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

export type Meta = Record<string, string>;

import {Meta} from "./Meta";
import {Author} from "./Author";
import {Location} from "./Location";
import {Web} from "./Web";

/**
 * An general news entry
 */
export interface News {
    config?: Meta
    tags?: Array<string>
    receiver: Array<Author>
    resources?: Array<Location | Web>
    profileImage?: string
    read?: boolean
    source?: Author | Web
    author?: Author
    meta?: Meta
    sendDate?: string
    readDate?: string
    expires?: string
    price: number
    rating?: number
    content: string
    question?: string
    version?: string
    coffeeTime?: string
    profileUri?: string
    captcha?: string
}
