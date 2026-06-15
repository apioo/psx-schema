package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents an integer value")
public class IntegerPropertyType extends ScalarPropertyType {
    @JsonProperty("type")
    private String type = "integer";


    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return this.type;
    }
}

