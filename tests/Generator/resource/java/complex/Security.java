package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = SecurityApiKey.class, name = "apiKey"),
    @JsonSubTypes.Type(value = SecurityHttpBasic.class, name = "httpBasic"),
    @JsonSubTypes.Type(value = SecurityHttpBearer.class, name = "httpBearer"),
    @JsonSubTypes.Type(value = SecurityOAuth.class, name = "oauth2"),
})
public abstract class Security {
    @JsonPropertyDescription("The global security type of the API must be one of: httpBasic, httpBearer, apiKey or oauth2")
    private String type;

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
}

