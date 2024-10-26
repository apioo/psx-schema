
import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a struct which contains a fixed set of defined properties
 */
public class StructDefinitionType extends DefinitionType {
    private String type;
    private String parent;
    private Boolean base;
    private java.util.Map<String, PropertyType> properties;
    private String discriminator;
    private java.util.Map<String, String> mapping;
    private java.util.Map<String, String> template;

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }

    @JsonSetter("parent")
    public void setParent(String parent) {
        this.parent = parent;
    }

    @JsonGetter("parent")
    public String getParent() {
        return this.parent;
    }

    @JsonSetter("base")
    public void setBase(Boolean base) {
        this.base = base;
    }

    @JsonGetter("base")
    public Boolean getBase() {
        return this.base;
    }

    @JsonSetter("properties")
    public void setProperties(java.util.Map<String, PropertyType> properties) {
        this.properties = properties;
    }

    @JsonGetter("properties")
    public java.util.Map<String, PropertyType> getProperties() {
        return this.properties;
    }

    @JsonSetter("discriminator")
    public void setDiscriminator(String discriminator) {
        this.discriminator = discriminator;
    }

    @JsonGetter("discriminator")
    public String getDiscriminator() {
        return this.discriminator;
    }

    @JsonSetter("mapping")
    public void setMapping(java.util.Map<String, String> mapping) {
        this.mapping = mapping;
    }

    @JsonGetter("mapping")
    public java.util.Map<String, String> getMapping() {
        return this.mapping;
    }

    @JsonSetter("template")
    public void setTemplate(java.util.Map<String, String> template) {
        this.template = template;
    }

    @JsonGetter("template")
    public java.util.Map<String, String> getTemplate() {
        return this.template;
    }
}

