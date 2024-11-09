package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

/**
 * Represents a generic value which can be replaced with a dynamic type
 */
public class GenericPropertyType extends PropertyType {
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

