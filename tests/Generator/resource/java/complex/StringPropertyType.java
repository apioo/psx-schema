package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents a string value")
public class StringPropertyType extends ScalarPropertyType {
    @JsonPropertyDescription("Optional a default value for this property")
    private String _default;
    @JsonPropertyDescription("Optional describes the format of the string. Supported are the following types: date, date-time and time. A code generator may use a fitting data type to represent such a format, if not supported it should fallback to a string")
    private String format;
    private String type = "string";

    @JsonSetter("default")
    public void setDefault(String _default) {
        this._default = _default;
    }

    @JsonGetter("default")
    public String getDefault() {
        return this._default;
    }

    @JsonSetter("format")
    public void setFormat(String format) {
        this.format = format;
    }

    @JsonGetter("format")
    public String getFormat() {
        return this.format;
    }

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
}

