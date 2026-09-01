import type {HumanType} from "./HumanType";

export type Student = HumanType & {
    matricleNumber?: string;
};

