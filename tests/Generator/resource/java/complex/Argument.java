package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Describes arguments of the operation")
public class Argument {
    @JsonPropertyDescription("In case the data is not a JSON payload which you can describe with a schema you can select a content type")
    private String contentType;
    @JsonPropertyDescription("The location where the value can be found either in the path, query, header or body. If you choose path, then your path must have a fitting variable path fragment")
    private String in;
    @JsonPropertyDescription("Optional the actual path, query or header name. If not provided the key of the argument map is used")
    private String name;
    @JsonPropertyDescription("Schema of the JSON payload")
    private PropertyType schema;

    @JsonSetter("contentType")
    public void setContentType(String contentType) {
        this.contentType = contentType;
    }

    @JsonGetter("contentType")
    public String getContentType() {
        return this.contentType;
    }

    @JsonSetter("in")
    public void setIn(String in) {
        this.in = in;
    }

    @JsonGetter("in")
    public String getIn() {
        return this.in;
    }

    @JsonSetter("name")
    public void setName(String name) {
        this.name = name;
    }

    @JsonGetter("name")
    public String getName() {
        return this.name;
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

