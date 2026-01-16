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
 * Base property type
 */
export interface PropertyType {
    deprecated?: boolean
    description?: string
    nullable?: boolean
    type?: string
}

