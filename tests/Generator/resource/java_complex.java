import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * Common properties which can be used at any schema
 */
public class CommonProperties {
    private String title;
    private String description;
    private String type;
    private boolean nullable;
    private boolean deprecated;
    private boolean readonly;
    @JsonProperty("title")
    public void setTitle(String title) {
        this.title = title;
    }
    @JsonProperty("title")
    public String getTitle() {
        return this.title;
    }
    @JsonProperty("description")
    public void setDescription(String description) {
        this.description = description;
    }
    @JsonProperty("description")
    public String getDescription() {
        return this.description;
    }
    @JsonProperty("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonProperty("type")
    public String getType() {
        return this.type;
    }
    @JsonProperty("nullable")
    public void setNullable(boolean nullable) {
        this.nullable = nullable;
    }
    @JsonProperty("nullable")
    public boolean getNullable() {
        return this.nullable;
    }
    @JsonProperty("deprecated")
    public void setDeprecated(boolean deprecated) {
        this.deprecated = deprecated;
    }
    @JsonProperty("deprecated")
    public boolean getDeprecated() {
        return this.deprecated;
    }
    @JsonProperty("readonly")
    public void setReadonly(boolean readonly) {
        this.readonly = readonly;
    }
    @JsonProperty("readonly")
    public boolean getReadonly() {
        return this.readonly;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("title", this.title);
        map.put("description", this.description);
        map.put("type", this.type);
        map.put("nullable", this.nullable);
        map.put("deprecated", this.deprecated);
        map.put("readonly", this.readonly);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
public class ScalarProperties {
    private String format;
    private Object _enum;
    private Object _default;
    @JsonProperty("format")
    public void setFormat(String format) {
        this.format = format;
    }
    @JsonProperty("format")
    public String getFormat() {
        return this.format;
    }
    @JsonProperty("enum")
    public void setEnum(Object _enum) {
        this._enum = _enum;
    }
    @JsonProperty("enum")
    public Object getEnum() {
        return this._enum;
    }
    @JsonProperty("default")
    public void setDefault(Object _default) {
        this._default = _default;
    }
    @JsonProperty("default")
    public Object getDefault() {
        return this._default;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("format", this.format);
        map.put("enum", this._enum);
        map.put("default", this._default);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
import java.util.HashMap;

/**
 * Properties of a schema
 */
public class Properties extends HashMap<String, PropertyValue> {
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * Properties specific for a container
 */
public class ContainerProperties {
    private String type;
    @JsonProperty("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonProperty("type")
    public String getType() {
        return this.type;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("type", this.type);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * Struct specific properties
 */
public class StructProperties {
    private Properties properties;
    private String[] required;
    @JsonProperty("properties")
    public void setProperties(Properties properties) {
        this.properties = properties;
    }
    @JsonProperty("properties")
    public Properties getProperties() {
        return this.properties;
    }
    @JsonProperty("required")
    public void setRequired(String[] required) {
        this.required = required;
    }
    @JsonProperty("required")
    public String[] getRequired() {
        return this.required;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("properties", this.properties);
        map.put("required", this.required);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * Map specific properties
 */
public class MapProperties {
    private Object additionalProperties;
    private int maxProperties;
    private int minProperties;
    @JsonProperty("additionalProperties")
    public void setAdditionalProperties(Object additionalProperties) {
        this.additionalProperties = additionalProperties;
    }
    @JsonProperty("additionalProperties")
    public Object getAdditionalProperties() {
        return this.additionalProperties;
    }
    @JsonProperty("maxProperties")
    public void setMaxProperties(int maxProperties) {
        this.maxProperties = maxProperties;
    }
    @JsonProperty("maxProperties")
    public int getMaxProperties() {
        return this.maxProperties;
    }
    @JsonProperty("minProperties")
    public void setMinProperties(int minProperties) {
        this.minProperties = minProperties;
    }
    @JsonProperty("minProperties")
    public int getMinProperties() {
        return this.minProperties;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("additionalProperties", this.additionalProperties);
        map.put("maxProperties", this.maxProperties);
        map.put("minProperties", this.minProperties);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * Array properties
 */
public class ArrayProperties {
    private String type;
    private Object items;
    private int maxItems;
    private int minItems;
    private boolean uniqueItems;
    @JsonProperty("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonProperty("type")
    public String getType() {
        return this.type;
    }
    @JsonProperty("items")
    public void setItems(Object items) {
        this.items = items;
    }
    @JsonProperty("items")
    public Object getItems() {
        return this.items;
    }
    @JsonProperty("maxItems")
    public void setMaxItems(int maxItems) {
        this.maxItems = maxItems;
    }
    @JsonProperty("maxItems")
    public int getMaxItems() {
        return this.maxItems;
    }
    @JsonProperty("minItems")
    public void setMinItems(int minItems) {
        this.minItems = minItems;
    }
    @JsonProperty("minItems")
    public int getMinItems() {
        return this.minItems;
    }
    @JsonProperty("uniqueItems")
    public void setUniqueItems(boolean uniqueItems) {
        this.uniqueItems = uniqueItems;
    }
    @JsonProperty("uniqueItems")
    public boolean getUniqueItems() {
        return this.uniqueItems;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("type", this.type);
        map.put("items", this.items);
        map.put("maxItems", this.maxItems);
        map.put("minItems", this.minItems);
        map.put("uniqueItems", this.uniqueItems);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * Boolean properties
 */
public class BooleanProperties {
    private String type;
    @JsonProperty("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonProperty("type")
    public String getType() {
        return this.type;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("type", this.type);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * Number properties
 */
public class NumberProperties {
    private String type;
    private float multipleOf;
    private float maximum;
    private boolean exclusiveMaximum;
    private float minimum;
    private boolean exclusiveMinimum;
    @JsonProperty("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonProperty("type")
    public String getType() {
        return this.type;
    }
    @JsonProperty("multipleOf")
    public void setMultipleOf(float multipleOf) {
        this.multipleOf = multipleOf;
    }
    @JsonProperty("multipleOf")
    public float getMultipleOf() {
        return this.multipleOf;
    }
    @JsonProperty("maximum")
    public void setMaximum(float maximum) {
        this.maximum = maximum;
    }
    @JsonProperty("maximum")
    public float getMaximum() {
        return this.maximum;
    }
    @JsonProperty("exclusiveMaximum")
    public void setExclusiveMaximum(boolean exclusiveMaximum) {
        this.exclusiveMaximum = exclusiveMaximum;
    }
    @JsonProperty("exclusiveMaximum")
    public boolean getExclusiveMaximum() {
        return this.exclusiveMaximum;
    }
    @JsonProperty("minimum")
    public void setMinimum(float minimum) {
        this.minimum = minimum;
    }
    @JsonProperty("minimum")
    public float getMinimum() {
        return this.minimum;
    }
    @JsonProperty("exclusiveMinimum")
    public void setExclusiveMinimum(boolean exclusiveMinimum) {
        this.exclusiveMinimum = exclusiveMinimum;
    }
    @JsonProperty("exclusiveMinimum")
    public boolean getExclusiveMinimum() {
        return this.exclusiveMinimum;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("type", this.type);
        map.put("multipleOf", this.multipleOf);
        map.put("maximum", this.maximum);
        map.put("exclusiveMaximum", this.exclusiveMaximum);
        map.put("minimum", this.minimum);
        map.put("exclusiveMinimum", this.exclusiveMinimum);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * String properties
 */
public class StringProperties {
    private String type;
    private int maxLength;
    private int minLength;
    private String pattern;
    @JsonProperty("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonProperty("type")
    public String getType() {
        return this.type;
    }
    @JsonProperty("maxLength")
    public void setMaxLength(int maxLength) {
        this.maxLength = maxLength;
    }
    @JsonProperty("maxLength")
    public int getMaxLength() {
        return this.maxLength;
    }
    @JsonProperty("minLength")
    public void setMinLength(int minLength) {
        this.minLength = minLength;
    }
    @JsonProperty("minLength")
    public int getMinLength() {
        return this.minLength;
    }
    @JsonProperty("pattern")
    public void setPattern(String pattern) {
        this.pattern = pattern;
    }
    @JsonProperty("pattern")
    public String getPattern() {
        return this.pattern;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("type", this.type);
        map.put("maxLength", this.maxLength);
        map.put("minLength", this.minLength);
        map.put("pattern", this.pattern);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
import java.util.HashMap;

/**
 * An object to hold mappings between payload values and schema names or references
 */
public class DiscriminatorMapping extends HashMap<String, String> {
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
public class Discriminator {
    private String propertyName;
    private DiscriminatorMapping mapping;
    @JsonProperty("propertyName")
    public void setPropertyName(String propertyName) {
        this.propertyName = propertyName;
    }
    @JsonProperty("propertyName")
    public String getPropertyName() {
        return this.propertyName;
    }
    @JsonProperty("mapping")
    public void setMapping(DiscriminatorMapping mapping) {
        this.mapping = mapping;
    }
    @JsonProperty("mapping")
    public DiscriminatorMapping getMapping() {
        return this.mapping;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("propertyName", this.propertyName);
        map.put("mapping", this.mapping);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * An intersection type combines multiple schemas into one
 */
public class AllOfProperties {
    private String description;
    private OfValue[] allOf;
    @JsonProperty("description")
    public void setDescription(String description) {
        this.description = description;
    }
    @JsonProperty("description")
    public String getDescription() {
        return this.description;
    }
    @JsonProperty("allOf")
    public void setAllOf(OfValue[] allOf) {
        this.allOf = allOf;
    }
    @JsonProperty("allOf")
    public OfValue[] getAllOf() {
        return this.allOf;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("description", this.description);
        map.put("allOf", this.allOf);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * An union type can contain one of the provided schemas
 */
public class OneOfProperties {
    private String description;
    private Discriminator discriminator;
    private OfValue[] oneOf;
    @JsonProperty("description")
    public void setDescription(String description) {
        this.description = description;
    }
    @JsonProperty("description")
    public String getDescription() {
        return this.description;
    }
    @JsonProperty("discriminator")
    public void setDiscriminator(Discriminator discriminator) {
        this.discriminator = discriminator;
    }
    @JsonProperty("discriminator")
    public Discriminator getDiscriminator() {
        return this.discriminator;
    }
    @JsonProperty("oneOf")
    public void setOneOf(OfValue[] oneOf) {
        this.oneOf = oneOf;
    }
    @JsonProperty("oneOf")
    public OfValue[] getOneOf() {
        return this.oneOf;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("description", this.description);
        map.put("discriminator", this.discriminator);
        map.put("oneOf", this.oneOf);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
import java.util.HashMap;
public class TemplateProperties extends HashMap<String, ReferenceType> {
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * Represents a reference to another schema
 */
public class ReferenceType {
    private String ref;
    private TemplateProperties template;
    @JsonProperty("$ref")
    public void setRef(String ref) {
        this.ref = ref;
    }
    @JsonProperty("$ref")
    public String getRef() {
        return this.ref;
    }
    @JsonProperty("$template")
    public void setTemplate(TemplateProperties template) {
        this.template = template;
    }
    @JsonProperty("$template")
    public TemplateProperties getTemplate() {
        return this.template;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("$ref", this.ref);
        map.put("$template", this.template);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * Represents a generic type
 */
public class GenericType {
    private String generic;
    @JsonProperty("$generic")
    public void setGeneric(String generic) {
        this.generic = generic;
    }
    @JsonProperty("$generic")
    public String getGeneric() {
        return this.generic;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("$generic", this.generic);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
import java.util.HashMap;

/**
 * Schema definitions which can be reused
 */
public class Definitions extends HashMap<String, DefinitionValue> {
}

import com.fasterxml.jackson.annotation.JsonProperty;
import java.util.HashMap;

/**
 * Contains external definitions which are imported. The imported schemas can be used via the namespace
 */
public class Import extends HashMap<String, String> {
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * TypeSchema meta schema which describes a TypeSchema
 */
public class TypeSchema {
    private Import _import;
    private String title;
    private String description;
    private String type;
    private Definitions definitions;
    private Properties properties;
    private String[] required;
    @JsonProperty("$import")
    public void setImport(Import _import) {
        this._import = _import;
    }
    @JsonProperty("$import")
    public Import getImport() {
        return this._import;
    }
    @JsonProperty("title")
    public void setTitle(String title) {
        this.title = title;
    }
    @JsonProperty("title")
    public String getTitle() {
        return this.title;
    }
    @JsonProperty("description")
    public void setDescription(String description) {
        this.description = description;
    }
    @JsonProperty("description")
    public String getDescription() {
        return this.description;
    }
    @JsonProperty("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonProperty("type")
    public String getType() {
        return this.type;
    }
    @JsonProperty("definitions")
    public void setDefinitions(Definitions definitions) {
        this.definitions = definitions;
    }
    @JsonProperty("definitions")
    public Definitions getDefinitions() {
        return this.definitions;
    }
    @JsonProperty("properties")
    public void setProperties(Properties properties) {
        this.properties = properties;
    }
    @JsonProperty("properties")
    public Properties getProperties() {
        return this.properties;
    }
    @JsonProperty("required")
    public void setRequired(String[] required) {
        this.required = required;
    }
    @JsonProperty("required")
    public String[] getRequired() {
        return this.required;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("$import", this._import);
        map.put("title", this.title);
        map.put("description", this.description);
        map.put("type", this.type);
        map.put("definitions", this.definitions);
        map.put("properties", this.properties);
        map.put("required", this.required);
        return map;
    }
}
