package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents an array which contains a dynamic list of values of the same type")
public class ArrayDefinitionType extends CollectionDefinitionType {
    private String type = "array";

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
}

