
import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Base type for the map and array collection type
 */
@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, include = JsonTypeInfo.As.PROPERTY, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = MapDefinitionType.class, name = "map"),
    @JsonSubTypes.Type(value = ArrayDefinitionType.class, name = "array"),
})
public abstract class CollectionDefinitionType extends DefinitionType {
    private String type;
    private PropertyType schema;

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }

    @JsonSetter("schema")
    public void setSchema(PropertyType schema) {
        this.schema = schema;
    }

    @JsonGetter("schema")
    public PropertyType getSchema() {
        return this.schema;
    }
}

