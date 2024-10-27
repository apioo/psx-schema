import {Security} from "./Security";

export interface SecurityApiKey extends Security {
    name?: string
    in?: string
}

