package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

/**
 * Represents a reference to a definition type
 */
public class ReferencePropertyType extends PropertyType {
    private String target;
    private java.util.Map<String, String> template;

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
}

