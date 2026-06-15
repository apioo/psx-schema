package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("A struct represents a class/structure with a fix set of defined properties")
public class StructDefinitionType extends DefinitionType {
    @JsonPropertyDescription("Indicates whether this is a base structure, default is false. If true the structure is used a base type, this means it is not possible to create an instance from this structure")
    @JsonProperty("base")
    private Boolean base;

    @JsonPropertyDescription("Optional the property name of a discriminator property. This should be only used in case this is also a base structure")
    @JsonProperty("discriminator")
    private String discriminator;

    @JsonPropertyDescription("In case a discriminator is configured it is required to configure a mapping. The mapping is a map where the key is the type name (a key from the definitions map) and the value the actual discriminator type value")
    @JsonProperty("mapping")
    private java.util.Map<String, String> mapping;

    @JsonPropertyDescription("Defines a parent type, all properties from the parent type are inherited")
    @JsonProperty("parent")
    private ReferencePropertyType parent;

    @JsonPropertyDescription("Contains a map of available properties for this struct")
    @JsonProperty("properties")
    private java.util.Map<String, PropertyType> properties;

    @JsonProperty("type")
    private String type = "struct";


    public void setBase(Boolean base) {
        this.base = base;
    }

    public Boolean getBase() {
        return this.base;
    }

    public void setDiscriminator(String discriminator) {
        this.discriminator = discriminator;
    }

    public String getDiscriminator() {
        return this.discriminator;
    }

    public void setMapping(java.util.Map<String, String> mapping) {
        this.mapping = mapping;
    }

    public java.util.Map<String, String> getMapping() {
        return this.mapping;
    }

    public void setParent(ReferencePropertyType parent) {
        this.parent = parent;
    }

    public ReferencePropertyType getParent() {
        return this.parent;
    }

    public void setProperties(java.util.Map<String, PropertyType> properties) {
        this.properties = properties;
    }

    public java.util.Map<String, PropertyType> getProperties() {
        return this.properties;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return this.type;
    }
}

