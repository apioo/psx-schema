package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = ArrayDefinitionType.class, name = "array"),
    @JsonSubTypes.Type(value = MapDefinitionType.class, name = "map"),
    @JsonSubTypes.Type(value = StructDefinitionType.class, name = "struct"),
})
@JsonClassDescription("Base definition type")
public abstract class DefinitionType {
    @JsonProperty("deprecated")
    private Boolean deprecated;

    @JsonProperty("description")
    private String description;

    @JsonProperty("type")
    private String type;


    public void setDeprecated(Boolean deprecated) {
        this.deprecated = deprecated;
    }

    public Boolean getDeprecated() {
        return this.deprecated;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getDescription() {
        return this.description;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return this.type;
    }
}

