package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents an array which contains a dynamic list of values of the same type")
public class ArrayDefinitionType extends CollectionDefinitionType {
    @JsonProperty("type")
    private String type = "array";


    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return this.type;
    }
}

