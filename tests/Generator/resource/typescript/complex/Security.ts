import {SecurityHttpBasic} from "./SecurityHttpBasic";
import {SecurityHttpBearer} from "./SecurityHttpBearer";
import {SecurityApiKey} from "./SecurityApiKey";
import {SecurityOAuth} from "./SecurityOAuth2";

export interface Security {
    type?: string
}

