package org.typeapi.model;

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * The TypeAPI Root
 */
public class TypeAPI extends TypeSchema {
    private String baseUrl;
    private Security security;
    private java.util.Map<String, Operation> operations;

    @JsonSetter("baseUrl")
    public void setBaseUrl(String baseUrl) {
        this.baseUrl = baseUrl;
    }

    @JsonGetter("baseUrl")
    public String getBaseUrl() {
        return this.baseUrl;
    }

    @JsonSetter("security")
    public void setSecurity(Security security) {
        this.security = security;
    }

    @JsonGetter("security")
    public Security getSecurity() {
        return this.security;
    }

    @JsonSetter("operations")
    public void setOperations(java.util.Map<String, Operation> operations) {
        this.operations = operations;
    }

    @JsonGetter("operations")
    public java.util.Map<String, Operation> getOperations() {
        return this.operations;
    }
}

