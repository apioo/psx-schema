package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

public class Operation {
    @JsonPropertyDescription("All arguments provided to this operation. Each argument is mapped to a location from the HTTP request i.e. query or body")
    private java.util.Map<String, Argument> arguments;
    @JsonPropertyDescription("Indicates whether this operation needs authorization, if set to false the client will not send an authorization header, default it is true")
    private Boolean authorization;
    @JsonPropertyDescription("A short description of this operation. The generated code will include this description at the method so it is recommend to use simple alphanumeric characters and no new lines")
    private String description;
    @JsonPropertyDescription("The HTTP method which is associated with this operation, must be a valid HTTP method i.e. GET, POST, PUT etc.")
    private String method;
    @JsonPropertyDescription("The HTTP path which is associated with this operation. A path can also include variable path fragments i.e. /my/path/:year then you can map the variable year path fragment to a specific argument")
    private String path;
    @JsonPropertyDescription("The return type of this operation. The return has also an assigned HTTP success status code which is by default 200")
    private Response _return;
    @JsonPropertyDescription("An array of scopes which are required to access this operation")
    private java.util.List<String> security;
    @JsonPropertyDescription("Indicates the stability of this operation: 0 - Deprecated, 1 - Experimental, 2 - Stable, 3 - Legacy. If not explicit provided the operation is by default experimental")
    private Integer stability;
    @JsonPropertyDescription("All exceptional states which can occur in case the operation fails. Each exception is assigned to an HTTP error status code")
    private java.util.List<Response> _throws;

    @JsonSetter("arguments")
    public void setArguments(java.util.Map<String, Argument> arguments) {
        this.arguments = arguments;
    }

    @JsonGetter("arguments")
    public java.util.Map<String, Argument> getArguments() {
        return this.arguments;
    }

    @JsonSetter("authorization")
    public void setAuthorization(Boolean authorization) {
        this.authorization = authorization;
    }

    @JsonGetter("authorization")
    public Boolean getAuthorization() {
        return this.authorization;
    }

    @JsonSetter("description")
    public void setDescription(String description) {
        this.description = description;
    }

    @JsonGetter("description")
    public String getDescription() {
        return this.description;
    }

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

    @JsonSetter("security")
    public void setSecurity(java.util.List<String> security) {
        this.security = security;
    }

    @JsonGetter("security")
    public java.util.List<String> getSecurity() {
        return this.security;
    }

    @JsonSetter("stability")
    public void setStability(Integer stability) {
        this.stability = stability;
    }

    @JsonGetter("stability")
    public Integer getStability() {
        return this.stability;
    }

    @JsonSetter("throws")
    public void setThrows(java.util.List<Response> _throws) {
        this._throws = _throws;
    }

    @JsonGetter("throws")
    public java.util.List<Response> getThrows() {
        return this._throws;
    }
}

