import {StudentMap} from "./my_import/StudentMap";
import {Student} from "./my_import/Student";
export interface Import {
    students?: StudentMap
    student?: Student
}

import {Student} from "./my_import/Student";
export interface MyMap extends Student {
}
