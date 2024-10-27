package org.typeapi.model;

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Base definition type
 */
@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, include = JsonTypeInfo.As.PROPERTY, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = StructDefinitionType.class, name = "struct"),
    @JsonSubTypes.Type(value = MapDefinitionType.class, name = "map"),
    @JsonSubTypes.Type(value = ArrayDefinitionType.class, name = "array"),
})
public abstract class DefinitionType {
    private String description;
    private String type;
    private Boolean deprecated;

    @JsonSetter("description")
    public void setDescription(String description) {
        this.description = description;
    }

    @JsonGetter("description")
    public String getDescription() {
        return this.description;
    }

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }

    @JsonSetter("deprecated")
    public void setDeprecated(Boolean deprecated) {
        this.deprecated = deprecated;
    }

    @JsonGetter("deprecated")
    public Boolean getDeprecated() {
        return this.deprecated;
    }
}

