package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Represents a reference to a definition type")
public class ReferencePropertyType extends PropertyType {
    @JsonPropertyDescription("The target type, this must be a key which is available at the definitions map")
    @JsonProperty("target")
    private String target;

    @JsonPropertyDescription("A map where the key is the name of the generic and the value must point to a key under the definitions keyword. This can be used in case the target points to a type which contains generics, then it is possible to replace those generics with a concrete type")
    @JsonProperty("template")
    private java.util.Map<String, String> template;

    @JsonProperty("type")
    private String type = "reference";


    public void setTarget(String target) {
        this.target = target;
    }

    public String getTarget() {
        return this.target;
    }

    public void setTemplate(java.util.Map<String, String> template) {
        this.template = template;
    }

    public java.util.Map<String, String> getTemplate() {
        return this.template;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getType() {
        return this.type;
    }
}

