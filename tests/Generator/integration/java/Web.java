package org.phpsx.test;

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * An application
 */
public class Web {
    private String name;
    private String url;
    @JsonSetter("name")
    public void setName(String name) {
        this.name = name;
    }
    @JsonGetter("name")
    public String getName() {
        return this.name;
    }
    @JsonSetter("url")
    public void setUrl(String url) {
        this.url = url;
    }
    @JsonGetter("url")
    public String getUrl() {
        return this.url;
    }
}
