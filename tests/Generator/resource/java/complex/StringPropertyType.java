package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents a string value")
public class StringPropertyType extends ScalarPropertyType {
    @JsonPropertyDescription("Optional a default value for this property")
    @JsonProperty("default")
    private String _default;

    @JsonPropertyDescription("Optional describes the format of the string. Supported are the following types: date, date-time and time. A code generator may use a fitting data type to represent such a format, if not supported it should fallback to a string")
    @JsonProperty("format")
    private String format;

    @JsonProperty("type")
    private String type = "string";


    public void setDefault(String _default) {
        this._default = _default;
    }

    public String getDefault() {
        return this._default;
    }

    public void setFormat(String format) {
        this.format = format;
    }

    public String getFormat() {
        return this.format;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return this.type;
    }
}

