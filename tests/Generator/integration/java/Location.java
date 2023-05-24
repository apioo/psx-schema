package org.phpsx.test;

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Location of the person
 */
public class Location {
    private double lat;
    private double _long;
    @JsonSetter("lat")
    public void setLat(double lat) {
        this.lat = lat;
    }
    @JsonGetter("lat")
    public double getLat() {
        return this.lat;
    }
    @JsonSetter("long")
    public void setLong(double _long) {
        this._long = _long;
    }
    @JsonGetter("long")
    public double getLong() {
        return this._long;
    }
}
