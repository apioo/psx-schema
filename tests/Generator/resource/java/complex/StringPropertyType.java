package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents a string value")
public class StringPropertyType extends ScalarPropertyType {
    @JsonPropertyDescription("Optional describes the format of the string. Supported are the following types: date, date-time and time. A code generator may use a fitting data type to represent such a format, if not supported it should fall back to a string.")
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

