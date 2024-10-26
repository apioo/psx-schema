import {IntegerPropertyType} from "./IntegerPropertyType";
import {NumberPropertyType} from "./NumberPropertyType";
import {StringPropertyType} from "./StringPropertyType";
import {BooleanPropertyType} from "./BooleanPropertyType";
import {PropertyType} from "./PropertyType";

/**
 * Base scalar property type
 */
export interface ScalarPropertyType extends PropertyType {
    type?: string
}

