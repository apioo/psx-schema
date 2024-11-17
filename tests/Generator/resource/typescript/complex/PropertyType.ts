import {AnyPropertyType} from "./AnyPropertyType";
import {ArrayPropertyType} from "./ArrayPropertyType";
import {BooleanPropertyType} from "./BooleanPropertyType";
import {GenericPropertyType} from "./GenericPropertyType";
import {IntegerPropertyType} from "./IntegerPropertyType";
import {MapPropertyType} from "./MapPropertyType";
import {NumberPropertyType} from "./NumberPropertyType";
import {ReferencePropertyType} from "./ReferencePropertyType";
import {StringPropertyType} from "./StringPropertyType";

/**
 * Base property type
 */
export interface PropertyType {
    deprecated?: boolean
    description?: string
    nullable?: boolean
    type?: string
}

