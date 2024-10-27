
import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Base property type
 */
@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, include = JsonTypeInfo.As.PROPERTY, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = StringPropertyType.class, name = "string"),
    @JsonSubTypes.Type(value = IntegerPropertyType.class, name = "integer"),
    @JsonSubTypes.Type(value = NumberPropertyType.class, name = "number"),
    @JsonSubTypes.Type(value = BooleanPropertyType.class, name = "boolean"),
    @JsonSubTypes.Type(value = MapPropertyType.class, name = "map"),
    @JsonSubTypes.Type(value = ArrayPropertyType.class, name = "array"),
    @JsonSubTypes.Type(value = AnyPropertyType.class, name = "any"),
    @JsonSubTypes.Type(value = GenericPropertyType.class, name = "generic"),
    @JsonSubTypes.Type(value = ReferencePropertyType.class, name = "reference"),
})
public abstract class PropertyType {
    private String description;
    private String type;
    private Boolean deprecated;
    private Boolean nullable;

    @JsonSetter("description")
    public void setDescription(String description) {
        this.description = description;
    }

    @JsonGetter("description")
    public String getDescription() {
        return this.description;
    }

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }

    @JsonSetter("deprecated")
    public void setDeprecated(Boolean deprecated) {
        this.deprecated = deprecated;
    }

    @JsonGetter("deprecated")
    public Boolean getDeprecated() {
        return this.deprecated;
    }

    @JsonSetter("nullable")
    public void setNullable(Boolean nullable) {
        this.nullable = nullable;
    }

    @JsonGetter("nullable")
    public Boolean getNullable() {
        return this.nullable;
    }
}

