package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents a generic value which can be replaced with a dynamic type")
public class GenericPropertyType extends PropertyType {
    @JsonPropertyDescription("The name of the generic, it is recommended to use common generic names like T or TValue. These generics can then be replaced on usage with a concrete type through the template property at a reference.")
    private String name;

    @JsonSetter("name")
    public void setName(String name) {
        this.name = name;
    }

    @JsonGetter("name")
    public String getName() {
        return this.name;
    }
}

