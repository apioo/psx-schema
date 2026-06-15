package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents an any value which allows any kind of value")
public class AnyPropertyType extends PropertyType {
    @JsonProperty("type")
    private String type = "any";


    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return this.type;
    }
}

