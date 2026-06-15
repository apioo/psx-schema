package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents a float value")
public class NumberPropertyType extends ScalarPropertyType {
    @JsonProperty("type")
    private String type = "number";


    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return this.type;
    }
}

