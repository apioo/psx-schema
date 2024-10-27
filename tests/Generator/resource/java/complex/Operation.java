package org.typeapi.model;

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

public class Operation {
    private String method;
    private String path;
    private Response _return;
    private java.util.Map<String, Argument> arguments;
    private java.util.List<Response> _throws;
    private String description;
    private Integer stability;
    private java.util.List<String> security;
    private Boolean authorization;
    private java.util.List<String> tags;

    @JsonSetter("method")
    public void setMethod(String method) {
        this.method = method;
    }

    @JsonGetter("method")
    public String getMethod() {
        return this.method;
    }

    @JsonSetter("path")
    public void setPath(String path) {
        this.path = path;
    }

    @JsonGetter("path")
    public String getPath() {
        return this.path;
    }

    @JsonSetter("return")
    public void setReturn(Response _return) {
        this._return = _return;
    }

    @JsonGetter("return")
    public Response getReturn() {
        return this._return;
    }

    @JsonSetter("arguments")
    public void setArguments(java.util.Map<String, Argument> arguments) {
        this.arguments = arguments;
    }

    @JsonGetter("arguments")
    public java.util.Map<String, Argument> getArguments() {
        return this.arguments;
    }

    @JsonSetter("throws")
    public void setThrows(java.util.List<Response> _throws) {
        this._throws = _throws;
    }

    @JsonGetter("throws")
    public java.util.List<Response> getThrows() {
        return this._throws;
    }

    @JsonSetter("description")
    public void setDescription(String description) {
        this.description = description;
    }

    @JsonGetter("description")
    public String getDescription() {
        return this.description;
    }

    @JsonSetter("stability")
    public void setStability(Integer stability) {
        this.stability = stability;
    }

    @JsonGetter("stability")
    public Integer getStability() {
        return this.stability;
    }

    @JsonSetter("security")
    public void setSecurity(java.util.List<String> security) {
        this.security = security;
    }

    @JsonGetter("security")
    public java.util.List<String> getSecurity() {
        return this.security;
    }

    @JsonSetter("authorization")
    public void setAuthorization(Boolean authorization) {
        this.authorization = authorization;
    }

    @JsonGetter("authorization")
    public Boolean getAuthorization() {
        return this.authorization;
    }

    @JsonSetter("tags")
    public void setTags(java.util.List<String> tags) {
        this.tags = tags;
    }

    @JsonGetter("tags")
    public java.util.List<String> getTags() {
        return this.tags;
    }
}

