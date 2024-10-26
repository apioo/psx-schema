
import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Location of the person
 */
public class Location {
    private Double lat;
    private Double _long;

    @JsonSetter("lat")
    public void setLat(Double lat) {
        this.lat = lat;
    }

    @JsonGetter("lat")
    public Double getLat() {
        return this.lat;
    }

    @JsonSetter("long")
    public void setLong(Double _long) {
        this._long = _long;
    }

    @JsonGetter("long")
    public Double getLong() {
        return this._long;
    }
}

