package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("The TypeAPI Root")
public class TypeAPI extends TypeSchema {
    @JsonPropertyDescription("Optional the base url of the service, if provided the user does not need to provide a base url for your client")
    private String baseUrl;
    @JsonPropertyDescription("A map of operations which are provided by the API. The key of the operation should be separated by a dot to group operations into logical units i.e. product.getAll or enterprise.product.execute")
    private java.util.Map<String, Operation> operations;
    @JsonPropertyDescription("Describes the authorization mechanism which is used by your API")
    private Security security;

    @JsonSetter("baseUrl")
    public void setBaseUrl(String baseUrl) {
        this.baseUrl = baseUrl;
    }

    @JsonGetter("baseUrl")
    public String getBaseUrl() {
        return this.baseUrl;
    }

    @JsonSetter("operations")
    public void setOperations(java.util.Map<String, Operation> operations) {
        this.operations = operations;
    }

    @JsonGetter("operations")
    public java.util.Map<String, Operation> getOperations() {
        return this.operations;
    }

    @JsonSetter("security")
    public void setSecurity(Security security) {
        this.security = security;
    }

    @JsonGetter("security")
    public Security getSecurity() {
        return this.security;
    }
}

