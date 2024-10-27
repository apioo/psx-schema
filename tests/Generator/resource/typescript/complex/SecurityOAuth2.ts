import {Security} from "./Security";

export interface SecurityOAuth extends Security {
    tokenUrl?: string
    authorizationUrl?: string
    scopes?: Array<string>
}

