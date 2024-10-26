import {Map} from "./Map";
import {Human} from "./Human";
import {Student} from "./Student";

export interface StudentMap extends Map<Human, Student> {
}

