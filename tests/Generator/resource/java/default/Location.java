
import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("Location of the person")
public class Location {
    @JsonProperty("lat")
    private Double lat;

    @JsonProperty("long")
    private Double _long;


    public void setLat(Double lat) {
        this.lat = lat;
    }

    public Double getLat() {
        return this.lat;
    }

    public void setLong(Double _long) {
        this._long = _long;
    }

    public Double getLong() {
        return this._long;
    }
}

