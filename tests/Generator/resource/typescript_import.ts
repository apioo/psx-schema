import {StudentMap} from "./StudentMap";
import {Student} from "./Student";
export interface Import {
    students?: StudentMap
    student?: Student
}

import {Student} from "./Student";
export interface MyMap extends Student {
}
