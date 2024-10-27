package org.typeapi.model;

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Base collection type
 */
@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, include = JsonTypeInfo.As.PROPERTY, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = MapDefinitionType.class, name = "map"),
    @JsonSubTypes.Type(value = ArrayDefinitionType.class, name = "array"),
})
public abstract class CollectionDefinitionType extends DefinitionType {
    private PropertyType schema;

    @JsonSetter("schema")
    public void setSchema(PropertyType schema) {
        this.schema = schema;
    }

    @JsonGetter("schema")
    public PropertyType getSchema() {
        return this.schema;
    }
}

