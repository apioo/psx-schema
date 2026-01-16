package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents a reference to a definition type")
public class ReferencePropertyType extends PropertyType {
    @JsonPropertyDescription("The target type, this must be a key which is available at the definitions map")
    private String target;
    @JsonPropertyDescription("A map where the key is the name of the generic and the value must point to a key under the definitions keyword. This can be used in case the target points to a type which contains generics, then it is possible to replace those generics with a concrete type")
    private java.util.Map<String, String> template;
    private String type = "reference";

    @JsonSetter("target")
    public void setTarget(String target) {
        this.target = target;
    }

    @JsonGetter("target")
    public String getTarget() {
        return this.target;
    }

    @JsonSetter("template")
    public void setTemplate(java.util.Map<String, String> template) {
        this.template = template;
    }

    @JsonGetter("template")
    public java.util.Map<String, String> getTemplate() {
        return this.template;
    }

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
}

