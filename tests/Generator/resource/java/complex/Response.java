package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Describes the response of the operation")
public class Response {
    @JsonPropertyDescription("The associated HTTP response code. For error responses it is possible to use the 499, 599 or 999 status code to catch all errors")
    private Integer code;
    @JsonPropertyDescription("In case the data is not a JSON payload which you can describe with a schema you can select a content type")
    private String contentType;
    @JsonPropertyDescription("Schema of the JSON payload")
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

