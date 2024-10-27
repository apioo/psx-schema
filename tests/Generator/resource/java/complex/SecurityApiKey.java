package org.typeapi.model;

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

public class SecurityApiKey extends Security {
    private String name;
    private String in;

    @JsonSetter("name")
    public void setName(String name) {
        this.name = name;
    }

    @JsonGetter("name")
    public String getName() {
        return this.name;
    }

    @JsonSetter("in")
    public void setIn(String in) {
        this.in = in;
    }

    @JsonGetter("in")
    public String getIn() {
        return this.in;
    }
}

