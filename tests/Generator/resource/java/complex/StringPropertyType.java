package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

/**
 * Represents a string value
 */
public class StringPropertyType extends ScalarPropertyType {
    private String format;

    @JsonSetter("format")
    public void setFormat(String format) {
        this.format = format;
    }

    @JsonGetter("format")
    public String getFormat() {
        return this.format;
    }
}

