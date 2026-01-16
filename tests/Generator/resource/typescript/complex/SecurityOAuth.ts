import type {Security} from "./Security";

export interface SecurityOAuth extends Security {
    type: "oauth2"
    authorizationUrl?: string
    scopes?: Array<string>
    tokenUrl?: string
}

