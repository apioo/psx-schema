package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

/**
 * A struct represents a class/structure with a fix set of defined properties.
 */
public class StructDefinitionType extends DefinitionType {
    private Boolean base;
    private String discriminator;
    private java.util.Map<String, String> mapping;
    private ReferencePropertyType parent;
    private java.util.Map<String, PropertyType> properties;

    @JsonSetter("base")
    public void setBase(Boolean base) {
        this.base = base;
    }

    @JsonGetter("base")
    public Boolean getBase() {
        return this.base;
    }

    @JsonSetter("discriminator")
    public void setDiscriminator(String discriminator) {
        this.discriminator = discriminator;
    }

    @JsonGetter("discriminator")
    public String getDiscriminator() {
        return this.discriminator;
    }

    @JsonSetter("mapping")
    public void setMapping(java.util.Map<String, String> mapping) {
        this.mapping = mapping;
    }

    @JsonGetter("mapping")
    public java.util.Map<String, String> getMapping() {
        return this.mapping;
    }

    @JsonSetter("parent")
    public void setParent(ReferencePropertyType parent) {
        this.parent = parent;
    }

    @JsonGetter("parent")
    public ReferencePropertyType getParent() {
        return this.parent;
    }

    @JsonSetter("properties")
    public void setProperties(java.util.Map<String, PropertyType> properties) {
        this.properties = properties;
    }

    @JsonGetter("properties")
    public java.util.Map<String, PropertyType> getProperties() {
        return this.properties;
    }
}

