import type {Security} from "./Security";

export interface SecurityApiKey extends Security {
    type: "apiKey"
    in?: string
    name?: string
}

