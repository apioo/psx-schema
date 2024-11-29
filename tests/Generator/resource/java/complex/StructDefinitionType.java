package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("A struct represents a class/structure with a fix set of defined properties.")
public class StructDefinitionType extends DefinitionType {
    @JsonPropertyDescription("Indicates whether this is a base structure, default is false. If true the structure is used a base type, this means it is not possible to create an instance from this structure.")
    private Boolean base;
    @JsonPropertyDescription("Optional the property name of a discriminator property. This should be only used in case this is also a base structure.")
    private String discriminator;
    @JsonPropertyDescription("In case a discriminator is configured it is required to configure a mapping. The mapping is a map where the key is the type name and the value the actual discriminator type value.")
    private java.util.Map<String, String> mapping;
    @JsonPropertyDescription("Defines a parent type for this structure. Some programming languages like Go do not support the concept of an extends, in this case the code generator simply copies all properties into this structure.")
    private ReferencePropertyType parent;
    @JsonPropertyDescription("Contains a map of available properties for this struct.")
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

