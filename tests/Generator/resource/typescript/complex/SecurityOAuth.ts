import type {Security} from "./Security";

export interface SecurityOAuth extends Security {
    authorizationUrl?: string
    scopes?: Array<string>
    tokenUrl?: string
}

