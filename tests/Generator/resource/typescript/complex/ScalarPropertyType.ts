import {BooleanPropertyType} from "./BooleanPropertyType";
import {IntegerPropertyType} from "./IntegerPropertyType";
import {NumberPropertyType} from "./NumberPropertyType";
import {StringPropertyType} from "./StringPropertyType";
import {PropertyType} from "./PropertyType";

/**
 * Base scalar property type
 */
export interface ScalarPropertyType extends PropertyType {
    type?: string
}

