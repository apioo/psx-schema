package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

public class SecurityOAuth extends Security {
    @JsonPropertyDescription("Optional the OAuth2 authorization endpoint")
    private String authorizationUrl;
    @JsonPropertyDescription("Optional OAuth2 scopes")
    private java.util.List<String> scopes;
    @JsonPropertyDescription("The OAuth2 token endpoint")
    private String tokenUrl;

    @JsonSetter("authorizationUrl")
    public void setAuthorizationUrl(String authorizationUrl) {
        this.authorizationUrl = authorizationUrl;
    }

    @JsonGetter("authorizationUrl")
    public String getAuthorizationUrl() {
        return this.authorizationUrl;
    }

    @JsonSetter("scopes")
    public void setScopes(java.util.List<String> scopes) {
        this.scopes = scopes;
    }

    @JsonGetter("scopes")
    public java.util.List<String> getScopes() {
        return this.scopes;
    }

    @JsonSetter("tokenUrl")
    public void setTokenUrl(String tokenUrl) {
        this.tokenUrl = tokenUrl;
    }

    @JsonGetter("tokenUrl")
    public String getTokenUrl() {
        return this.tokenUrl;
    }
}

