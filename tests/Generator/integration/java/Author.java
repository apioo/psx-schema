package org.phpsx.test;

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * An simple author element with some description
 */
public class Author {
    private String title;
    private String email;
    private String[] categories;
    private Location[] locations;
    private Location origin;
    @JsonSetter("title")
    public void setTitle(String title) {
        this.title = title;
    }
    @JsonGetter("title")
    public String getTitle() {
        return this.title;
    }
    @JsonSetter("email")
    public void setEmail(String email) {
        this.email = email;
    }
    @JsonGetter("email")
    public String getEmail() {
        return this.email;
    }
    @JsonSetter("categories")
    public void setCategories(String[] categories) {
        this.categories = categories;
    }
    @JsonGetter("categories")
    public String[] getCategories() {
        return this.categories;
    }
    @JsonSetter("locations")
    public void setLocations(Location[] locations) {
        this.locations = locations;
    }
    @JsonGetter("locations")
    public Location[] getLocations() {
        return this.locations;
    }
    @JsonSetter("origin")
    public void setOrigin(Location origin) {
        this.origin = origin;
    }
    @JsonGetter("origin")
    public Location getOrigin() {
        return this.origin;
    }
}
