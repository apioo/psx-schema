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
 * An simple author element with some description
 */
interface Author {
    title: string
    email?: string
    categories?: Array<string>
    locations?: Array<Location>
    origin?: Location
}

type Meta = Record<string, string>;

/**
 * An general news entry
 */
interface News {
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
