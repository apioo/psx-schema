package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents a boolean value")
public class BooleanPropertyType extends ScalarPropertyType {
    @JsonProperty("type")
    private String type = "boolean";


    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return this.type;
    }
}

