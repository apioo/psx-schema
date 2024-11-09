package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

/**
 * Base scalar property type
 */
@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = StringPropertyType.class, name = "string"),
    @JsonSubTypes.Type(value = IntegerPropertyType.class, name = "integer"),
    @JsonSubTypes.Type(value = NumberPropertyType.class, name = "number"),
    @JsonSubTypes.Type(value = BooleanPropertyType.class, name = "boolean"),
})
public abstract class ScalarPropertyType extends PropertyType {
}

