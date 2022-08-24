import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

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
    @JsonSetter("title")
    public void setTitle(String title) {
        this.title = title;
    }
    @JsonGetter("title")
    public String getTitle() {
        return this.title;
    }
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
    @JsonSetter("nullable")
    public void setNullable(boolean nullable) {
        this.nullable = nullable;
    }
    @JsonGetter("nullable")
    public boolean getNullable() {
        return this.nullable;
    }
    @JsonSetter("deprecated")
    public void setDeprecated(boolean deprecated) {
        this.deprecated = deprecated;
    }
    @JsonGetter("deprecated")
    public boolean getDeprecated() {
        return this.deprecated;
    }
    @JsonSetter("readonly")
    public void setReadonly(boolean readonly) {
        this.readonly = readonly;
    }
    @JsonGetter("readonly")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class ScalarProperties {
    private String format;
    private Object _enum;
    private Object _default;
    @JsonSetter("format")
    public void setFormat(String format) {
        this.format = format;
    }
    @JsonGetter("format")
    public String getFormat() {
        return this.format;
    }
    @JsonSetter("enum")
    public void setEnum(Object _enum) {
        this._enum = _enum;
    }
    @JsonGetter("enum")
    public Object getEnum() {
        return this._enum;
    }
    @JsonSetter("default")
    public void setDefault(Object _default) {
        this._default = _default;
    }
    @JsonGetter("default")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.HashMap;

/**
 * Properties of a schema
 */
public class Properties extends HashMap<String, PropertyValue> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Properties specific for a container
 */
public class ContainerProperties {
    private String type;
    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("type", this.type);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Struct specific properties
 */
public class StructProperties {
    private Properties properties;
    private String[] required;
    @JsonSetter("properties")
    public void setProperties(Properties properties) {
        this.properties = properties;
    }
    @JsonGetter("properties")
    public Properties getProperties() {
        return this.properties;
    }
    @JsonSetter("required")
    public void setRequired(String[] required) {
        this.required = required;
    }
    @JsonGetter("required")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Map specific properties
 */
public class MapProperties {
    private Object additionalProperties;
    private int maxProperties;
    private int minProperties;
    @JsonSetter("additionalProperties")
    public void setAdditionalProperties(Object additionalProperties) {
        this.additionalProperties = additionalProperties;
    }
    @JsonGetter("additionalProperties")
    public Object getAdditionalProperties() {
        return this.additionalProperties;
    }
    @JsonSetter("maxProperties")
    public void setMaxProperties(int maxProperties) {
        this.maxProperties = maxProperties;
    }
    @JsonGetter("maxProperties")
    public int getMaxProperties() {
        return this.maxProperties;
    }
    @JsonSetter("minProperties")
    public void setMinProperties(int minProperties) {
        this.minProperties = minProperties;
    }
    @JsonGetter("minProperties")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Array properties
 */
public class ArrayProperties {
    private String type;
    private Object items;
    private int maxItems;
    private int minItems;
    private boolean uniqueItems;
    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
    @JsonSetter("items")
    public void setItems(Object items) {
        this.items = items;
    }
    @JsonGetter("items")
    public Object getItems() {
        return this.items;
    }
    @JsonSetter("maxItems")
    public void setMaxItems(int maxItems) {
        this.maxItems = maxItems;
    }
    @JsonGetter("maxItems")
    public int getMaxItems() {
        return this.maxItems;
    }
    @JsonSetter("minItems")
    public void setMinItems(int minItems) {
        this.minItems = minItems;
    }
    @JsonGetter("minItems")
    public int getMinItems() {
        return this.minItems;
    }
    @JsonSetter("uniqueItems")
    public void setUniqueItems(boolean uniqueItems) {
        this.uniqueItems = uniqueItems;
    }
    @JsonGetter("uniqueItems")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Boolean properties
 */
public class BooleanProperties {
    private String type;
    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("type", this.type);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

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
    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
    @JsonSetter("multipleOf")
    public void setMultipleOf(float multipleOf) {
        this.multipleOf = multipleOf;
    }
    @JsonGetter("multipleOf")
    public float getMultipleOf() {
        return this.multipleOf;
    }
    @JsonSetter("maximum")
    public void setMaximum(float maximum) {
        this.maximum = maximum;
    }
    @JsonGetter("maximum")
    public float getMaximum() {
        return this.maximum;
    }
    @JsonSetter("exclusiveMaximum")
    public void setExclusiveMaximum(boolean exclusiveMaximum) {
        this.exclusiveMaximum = exclusiveMaximum;
    }
    @JsonGetter("exclusiveMaximum")
    public boolean getExclusiveMaximum() {
        return this.exclusiveMaximum;
    }
    @JsonSetter("minimum")
    public void setMinimum(float minimum) {
        this.minimum = minimum;
    }
    @JsonGetter("minimum")
    public float getMinimum() {
        return this.minimum;
    }
    @JsonSetter("exclusiveMinimum")
    public void setExclusiveMinimum(boolean exclusiveMinimum) {
        this.exclusiveMinimum = exclusiveMinimum;
    }
    @JsonGetter("exclusiveMinimum")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * String properties
 */
public class StringProperties {
    private String type;
    private int maxLength;
    private int minLength;
    private String pattern;
    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
    @JsonSetter("maxLength")
    public void setMaxLength(int maxLength) {
        this.maxLength = maxLength;
    }
    @JsonGetter("maxLength")
    public int getMaxLength() {
        return this.maxLength;
    }
    @JsonSetter("minLength")
    public void setMinLength(int minLength) {
        this.minLength = minLength;
    }
    @JsonGetter("minLength")
    public int getMinLength() {
        return this.minLength;
    }
    @JsonSetter("pattern")
    public void setPattern(String pattern) {
        this.pattern = pattern;
    }
    @JsonGetter("pattern")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.HashMap;

/**
 * An object to hold mappings between payload values and schema names or references
 */
public class DiscriminatorMapping extends HashMap<String, String> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
public class Discriminator {
    private String propertyName;
    private DiscriminatorMapping mapping;
    @JsonSetter("propertyName")
    public void setPropertyName(String propertyName) {
        this.propertyName = propertyName;
    }
    @JsonGetter("propertyName")
    public String getPropertyName() {
        return this.propertyName;
    }
    @JsonSetter("mapping")
    public void setMapping(DiscriminatorMapping mapping) {
        this.mapping = mapping;
    }
    @JsonGetter("mapping")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * An intersection type combines multiple schemas into one
 */
public class AllOfProperties {
    private String description;
    private OfValue[] allOf;
    @JsonSetter("description")
    public void setDescription(String description) {
        this.description = description;
    }
    @JsonGetter("description")
    public String getDescription() {
        return this.description;
    }
    @JsonSetter("allOf")
    public void setAllOf(OfValue[] allOf) {
        this.allOf = allOf;
    }
    @JsonGetter("allOf")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * An union type can contain one of the provided schemas
 */
public class OneOfProperties {
    private String description;
    private Discriminator discriminator;
    private OfValue[] oneOf;
    @JsonSetter("description")
    public void setDescription(String description) {
        this.description = description;
    }
    @JsonGetter("description")
    public String getDescription() {
        return this.description;
    }
    @JsonSetter("discriminator")
    public void setDiscriminator(Discriminator discriminator) {
        this.discriminator = discriminator;
    }
    @JsonGetter("discriminator")
    public Discriminator getDiscriminator() {
        return this.discriminator;
    }
    @JsonSetter("oneOf")
    public void setOneOf(OfValue[] oneOf) {
        this.oneOf = oneOf;
    }
    @JsonGetter("oneOf")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.HashMap;
public class TemplateProperties extends HashMap<String, ReferenceType> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a reference to another schema
 */
public class ReferenceType {
    private String ref;
    private TemplateProperties template;
    @JsonSetter("$ref")
    public void setRef(String ref) {
        this.ref = ref;
    }
    @JsonGetter("$ref")
    public String getRef() {
        return this.ref;
    }
    @JsonSetter("$template")
    public void setTemplate(TemplateProperties template) {
        this.template = template;
    }
    @JsonGetter("$template")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a generic type
 */
public class GenericType {
    private String generic;
    @JsonSetter("$generic")
    public void setGeneric(String generic) {
        this.generic = generic;
    }
    @JsonGetter("$generic")
    public String getGeneric() {
        return this.generic;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("$generic", this.generic);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.HashMap;

/**
 * Schema definitions which can be reused
 */
public class Definitions extends HashMap<String, DefinitionValue> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.HashMap;

/**
 * Contains external definitions which are imported. The imported schemas can be used via the namespace
 */
public class Import extends HashMap<String, String> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

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
    @JsonSetter("$import")
    public void setImport(Import _import) {
        this._import = _import;
    }
    @JsonGetter("$import")
    public Import getImport() {
        return this._import;
    }
    @JsonSetter("title")
    public void setTitle(String title) {
        this.title = title;
    }
    @JsonGetter("title")
    public String getTitle() {
        return this.title;
    }
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
    @JsonSetter("definitions")
    public void setDefinitions(Definitions definitions) {
        this.definitions = definitions;
    }
    @JsonGetter("definitions")
    public Definitions getDefinitions() {
        return this.definitions;
    }
    @JsonSetter("properties")
    public void setProperties(Properties properties) {
        this.properties = properties;
    }
    @JsonGetter("properties")
    public Properties getProperties() {
        return this.properties;
    }
    @JsonSetter("required")
    public void setRequired(String[] required) {
        this.required = required;
    }
    @JsonGetter("required")
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
