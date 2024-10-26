
import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a string value
 */
public class StringPropertyType extends ScalarPropertyType {
    private String type;
    private String format;

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }

    @JsonSetter("format")
    public void setFormat(String format) {
        this.format = format;
    }

    @JsonGetter("format")
    public String getFormat() {
        return this.format;
    }
}

