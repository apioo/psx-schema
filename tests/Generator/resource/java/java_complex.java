import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Base definition type
 */
@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, include = JsonTypeInfo.As.PROPERTY, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = StructDefinitionType.class, name = "struct"),
    @JsonSubTypes.Type(value = MapDefinitionType.class, name = "map"),
    @JsonSubTypes.Type(value = ArrayDefinitionType.class, name = "array"),
})
public abstract class DefinitionType {
    private String description;
    private Boolean deprecated;
    private String type;

    @JsonSetter("description")
    public void setDescription(String description) {
        this.description = description;
    }

    @JsonGetter("description")
    public String getDescription() {
        return this.description;
    }

    @JsonSetter("deprecated")
    public void setDeprecated(Boolean deprecated) {
        this.deprecated = deprecated;
    }

    @JsonGetter("deprecated")
    public Boolean getDeprecated() {
        return this.deprecated;
    }

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
}

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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a map which contains a dynamic set of key value entries
 */
public class MapDefinitionType extends CollectionDefinitionType {
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents an array which contains a dynamic list of values
 */
public class ArrayDefinitionType extends CollectionDefinitionType {
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Base property type
 */
@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, include = JsonTypeInfo.As.PROPERTY, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = IntegerPropertyType.class, name = "integer"),
    @JsonSubTypes.Type(value = NumberPropertyType.class, name = "number"),
    @JsonSubTypes.Type(value = StringPropertyType.class, name = "string"),
    @JsonSubTypes.Type(value = BooleanPropertyType.class, name = "boolean"),
    @JsonSubTypes.Type(value = MapPropertyType.class, name = "map"),
    @JsonSubTypes.Type(value = ArrayPropertyType.class, name = "array"),
    @JsonSubTypes.Type(value = AnyPropertyType.class, name = "any"),
    @JsonSubTypes.Type(value = GenericPropertyType.class, name = "generic"),
    @JsonSubTypes.Type(value = ReferencePropertyType.class, name = "reference"),
})
public abstract class PropertyType {
    private String description;
    private Boolean deprecated;
    private String type;
    private Boolean nullable;

    @JsonSetter("description")
    public void setDescription(String description) {
        this.description = description;
    }

    @JsonGetter("description")
    public String getDescription() {
        return this.description;
    }

    @JsonSetter("deprecated")
    public void setDeprecated(Boolean deprecated) {
        this.deprecated = deprecated;
    }

    @JsonGetter("deprecated")
    public Boolean getDeprecated() {
        return this.deprecated;
    }

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents an integer value
 */
public class IntegerPropertyType extends ScalarPropertyType {
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a float value
 */
public class NumberPropertyType extends ScalarPropertyType {
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a boolean value
 */
public class BooleanPropertyType extends ScalarPropertyType {
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Base collection property type
 */
@JsonTypeInfo(use = JsonTypeInfo.Id.NAME, include = JsonTypeInfo.As.PROPERTY, property = "type")
@JsonSubTypes({
    @JsonSubTypes.Type(value = MapPropertyType.class, name = "map"),
    @JsonSubTypes.Type(value = ArrayPropertyType.class, name = "array"),
})
public abstract class CollectionPropertyType extends PropertyType {
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a map which contains a dynamic set of key value entries
 */
public class MapPropertyType extends CollectionPropertyType {
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents an array which contains a dynamic list of values
 */
public class ArrayPropertyType extends CollectionPropertyType {
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents an any value which allows any kind of value
 */
public class AnyPropertyType extends PropertyType {
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a generic value which can be replaced with a dynamic type
 */
public class GenericPropertyType extends PropertyType {
    private String type;
    private String name;

    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }

    @JsonGetter("type")
    public String getType() {
        return this.type;
    }

    @JsonSetter("name")
    public void setName(String name) {
        this.name = name;
    }

    @JsonGetter("name")
    public String getName() {
        return this.name;
    }
}

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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class Specification {
    private java.util.Map<String, String> _import;
    private java.util.Map<String, DefinitionType> definitions;
    private String root;

    @JsonSetter("import")
    public void setImport(java.util.Map<String, String> _import) {
        this._import = _import;
    }

    @JsonGetter("import")
    public java.util.Map<String, String> getImport() {
        return this._import;
    }

    @JsonSetter("definitions")
    public void setDefinitions(java.util.Map<String, DefinitionType> definitions) {
        this.definitions = definitions;
    }

    @JsonGetter("definitions")
    public java.util.Map<String, DefinitionType> getDefinitions() {
        return this.definitions;
    }

    @JsonSetter("root")
    public void setRoot(String root) {
        this.root = root;
    }

    @JsonGetter("root")
    public String getRoot() {
        return this.root;
    }
}
