import type {Map} from "./Map";
import type {HumanType} from "./HumanType";
import type {Student} from "./Student";

export interface StudentMap extends Map<HumanType, Student> {
}

