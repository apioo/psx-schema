package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = ArrayPropertyType.class, name = "array"),
    @JsonSubTypes.Type(value = MapPropertyType.class, name = "map"),
})
@JsonClassDescription("Base collection property type")
public abstract class CollectionPropertyType extends PropertyType {
    @JsonProperty("schema")
    private PropertyType schema;

    @JsonProperty("type")
    private String type;


    public void setSchema(PropertyType schema) {
        this.schema = schema;
    }

    public PropertyType getSchema() {
        return this.schema;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return this.type;
    }
}

