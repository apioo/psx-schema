package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

public class Response {
    private Integer code;
    private String contentType;
    private PropertyType schema;

    @JsonSetter("code")
    public void setCode(Integer code) {
        this.code = code;
    }

    @JsonGetter("code")
    public Integer getCode() {
        return this.code;
    }

    @JsonSetter("contentType")
    public void setContentType(String contentType) {
        this.contentType = contentType;
    }

    @JsonGetter("contentType")
    public String getContentType() {
        return this.contentType;
    }

    @JsonSetter("schema")
    public void setSchema(PropertyType schema) {
        this.schema = schema;
    }

    @JsonGetter("schema")
    public PropertyType getSchema() {
        return this.schema;
    }
}

