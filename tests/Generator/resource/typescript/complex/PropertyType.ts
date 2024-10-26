import {IntegerPropertyType} from "./IntegerPropertyType";
import {NumberPropertyType} from "./NumberPropertyType";
import {StringPropertyType} from "./StringPropertyType";
import {BooleanPropertyType} from "./BooleanPropertyType";
import {MapPropertyType} from "./MapPropertyType";
import {ArrayPropertyType} from "./ArrayPropertyType";
import {AnyPropertyType} from "./AnyPropertyType";
import {GenericPropertyType} from "./GenericPropertyType";
import {ReferencePropertyType} from "./ReferencePropertyType";

/**
 * Base property type
 */
export interface PropertyType {
    description?: string
    deprecated?: boolean
    type?: string
    nullable?: boolean
}

