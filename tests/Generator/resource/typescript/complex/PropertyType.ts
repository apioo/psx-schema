import {StringPropertyType} from "./StringPropertyType";
import {IntegerPropertyType} from "./IntegerPropertyType";
import {NumberPropertyType} from "./NumberPropertyType";
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
    type?: string
    deprecated?: boolean
    nullable?: boolean
}

