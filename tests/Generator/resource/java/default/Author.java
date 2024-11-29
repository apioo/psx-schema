
import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("An simple author element with some description")
public class Author {
    private String title;
    @JsonPropertyDescription("We will send no spam to this address")
    private String email;
    private java.util.List<String> categories;
    @JsonPropertyDescription("Array of locations")
    private java.util.List<Location> locations;
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
    public void setCategories(java.util.List<String> categories) {
        this.categories = categories;
    }

    @JsonGetter("categories")
    public java.util.List<String> getCategories() {
        return this.categories;
    }

    @JsonSetter("locations")
    public void setLocations(java.util.List<Location> locations) {
        this.locations = locations;
    }

    @JsonGetter("locations")
    public java.util.List<Location> getLocations() {
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

