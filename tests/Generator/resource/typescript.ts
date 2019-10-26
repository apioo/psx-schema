/**
 * An general news entry
 */
interface News {
    config?: Config
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

interface Config {
    [index: string]: string
}

/**
 * An simple author element with some description
 */
interface Author {
    title: string
    email?: any
    categories?: Array<string>
    locations?: Array<Location>
    origin?: Location
}

/**
 * Location of the person
 */
interface Location {
    lat: number
    long: number
}

/**
 * An application
 */
interface Web {
    name: string
    url: string
}

/**
 * Some meta data
 */
interface Meta {
    createDate?: string
}
