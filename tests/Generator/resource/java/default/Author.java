
import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("An simple author element with some description")
public class Author {
    @JsonProperty("title")
    private String title;

    @JsonPropertyDescription("We will send no spam to this address")
    @JsonProperty("email")
    private String email;

    @JsonProperty("categories")
    private java.util.List<String> categories;

    @JsonPropertyDescription("Array of locations")
    @JsonProperty("locations")
    private java.util.List<Location> locations;

    @JsonProperty("origin")
    private Location origin;


    public void setTitle(String title) {
        this.title = title;
    }

    public String getTitle() {
        return this.title;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getEmail() {
        return this.email;
    }

    public void setCategories(java.util.List<String> categories) {
        this.categories = categories;
    }

    public java.util.List<String> getCategories() {
        return this.categories;
    }

    public void setLocations(java.util.List<Location> locations) {
        this.locations = locations;
    }

    public java.util.List<Location> getLocations() {
        return this.locations;
    }

    public void setOrigin(Location origin) {
        this.origin = origin;
    }

    public Location getOrigin() {
        return this.origin;
    }
}

