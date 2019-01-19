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
}
interface Config {
    [index: string]: string
}
interface Author {
    title: string
    email?: any
    categories?: Array<string>
    locations?: Array<Location>
    origin?: Location
}
interface Location {
    lat: number
    long: number
    [index: string]: any;
}
interface Web {
    name: string
    url: string
    [index: string]: string
}
interface Meta {
    createDate?: string
}
