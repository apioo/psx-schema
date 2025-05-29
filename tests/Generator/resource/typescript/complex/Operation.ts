import {Argument} from "./Argument";
import {Response} from "./Response";

export interface Operation {
    arguments?: Record<string, Argument>
    authorization?: boolean
    description?: string
    method?: string
    path?: string
    return?: Response
    security?: Array<string>
    stability?: number
    throws?: Array<Response>
}

