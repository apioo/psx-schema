
import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Base scalar property type
 */
@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, include = JsonTypeInfo.As.PROPERTY, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = IntegerPropertyType.class, name = "integer"),
    @JsonSubTypes.Type(value = NumberPropertyType.class, name = "number"),
    @JsonSubTypes.Type(value = StringPropertyType.class, name = "string"),
    @JsonSubTypes.Type(value = BooleanPropertyType.class, name = "boolean"),
})
public abstract class ScalarPropertyType extends PropertyType {
    private String type;

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
}

