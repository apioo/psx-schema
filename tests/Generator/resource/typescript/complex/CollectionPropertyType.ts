import type {ArrayPropertyType} from "./ArrayPropertyType";
import type {MapPropertyType} from "./MapPropertyType";
import type {PropertyType} from "./PropertyType";
import type {AnyPropertyType} from "./AnyPropertyType";
import type {BooleanPropertyType} from "./BooleanPropertyType";
import type {GenericPropertyType} from "./GenericPropertyType";
import type {IntegerPropertyType} from "./IntegerPropertyType";
import type {NumberPropertyType} from "./NumberPropertyType";
import type {ReferencePropertyType} from "./ReferencePropertyType";
import type {StringPropertyType} from "./StringPropertyType";

/**
 * Base collection property type
 */
export interface CollectionPropertyType extends PropertyType {
    schema?: AnyPropertyType|ArrayPropertyType|BooleanPropertyType|GenericPropertyType|IntegerPropertyType|MapPropertyType|NumberPropertyType|ReferencePropertyType|StringPropertyType
}

