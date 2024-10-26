
import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a reference to a definition type
 */
public class ReferencePropertyType extends PropertyType {
    private String type;
    private String target;

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }

    @JsonSetter("target")
    public void setTarget(String target) {
        this.target = target;
    }

    @JsonGetter("target")
    public String getTarget() {
        return this.target;
    }
}

