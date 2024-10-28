import {SecurityHttpBasic} from "./SecurityHttpBasic";
import {SecurityHttpBearer} from "./SecurityHttpBearer";
import {SecurityApiKey} from "./SecurityApiKey";
import {SecurityOAuth} from "./SecurityOAuth";

export interface Security {
    type?: string
}

