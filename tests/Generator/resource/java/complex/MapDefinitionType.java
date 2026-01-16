package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents a map which contains a dynamic set of key value entries of the same type")
public class MapDefinitionType extends CollectionDefinitionType {
    private String type = "map";

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
}

