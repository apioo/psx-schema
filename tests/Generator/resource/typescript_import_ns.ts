import {StudentMap} from "./StudentMap";
import {Student} from "./Student";
export interface Import {
    students?: My.Import.StudentMap
    student?: My.Import.Student
}

import {Student} from "./Student";
export interface MyMap extends My.Import.Student {
}
