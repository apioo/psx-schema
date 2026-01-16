import type {ArrayDefinitionType} from "./ArrayDefinitionType";
import type {MapDefinitionType} from "./MapDefinitionType";
import type {DefinitionType} from "./DefinitionType";
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
 * Base collection type
 */
export interface CollectionDefinitionType extends DefinitionType {
    schema?: AnyPropertyType|ArrayPropertyType|BooleanPropertyType|GenericPropertyType|IntegerPropertyType|MapPropertyType|NumberPropertyType|ReferencePropertyType|StringPropertyType
}

