package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents a map which contains a dynamic set of key value entries of the same type")
public class MapPropertyType extends CollectionPropertyType {
    @JsonProperty("type")
    private String type = "map";


    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return this.type;
    }
}

