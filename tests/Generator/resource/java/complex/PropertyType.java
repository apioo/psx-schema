package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = AnyPropertyType.class, name = "any"),
    @JsonSubTypes.Type(value = ArrayPropertyType.class, name = "array"),
    @JsonSubTypes.Type(value = BooleanPropertyType.class, name = "boolean"),
    @JsonSubTypes.Type(value = GenericPropertyType.class, name = "generic"),
    @JsonSubTypes.Type(value = IntegerPropertyType.class, name = "integer"),
    @JsonSubTypes.Type(value = MapPropertyType.class, name = "map"),
    @JsonSubTypes.Type(value = NumberPropertyType.class, name = "number"),
    @JsonSubTypes.Type(value = ReferencePropertyType.class, name = "reference"),
    @JsonSubTypes.Type(value = StringPropertyType.class, name = "string"),
})
@JsonClassDescription("Base property type")
public abstract class PropertyType {
    @JsonProperty("deprecated")
    private Boolean deprecated;

    @JsonProperty("description")
    private String description;

    @JsonProperty("nullable")
    private Boolean nullable;

    @JsonProperty("type")
    private String type;


    public void setDeprecated(Boolean deprecated) {
        this.deprecated = deprecated;
    }

    public Boolean getDeprecated() {
        return this.deprecated;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getDescription() {
        return this.description;
    }

    public void setNullable(Boolean nullable) {
        this.nullable = nullable;
    }

    public Boolean getNullable() {
        return this.nullable;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return this.type;
    }
}

