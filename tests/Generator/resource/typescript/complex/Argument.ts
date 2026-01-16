import type {PropertyType} from "./PropertyType";
import type {AnyPropertyType} from "./AnyPropertyType";
import type {ArrayPropertyType} from "./ArrayPropertyType";
import type {BooleanPropertyType} from "./BooleanPropertyType";
import type {GenericPropertyType} from "./GenericPropertyType";
import type {IntegerPropertyType} from "./IntegerPropertyType";
import type {MapPropertyType} from "./MapPropertyType";
import type {NumberPropertyType} from "./NumberPropertyType";
import type {ReferencePropertyType} from "./ReferencePropertyType";
import type {StringPropertyType} from "./StringPropertyType";

/**
 * Describes arguments of the operation
 */
export interface Argument {
    contentType?: string
    in?: string
    name?: string
    schema?: AnyPropertyType|ArrayPropertyType|BooleanPropertyType|GenericPropertyType|IntegerPropertyType|MapPropertyType|NumberPropertyType|ReferencePropertyType|StringPropertyType
}

