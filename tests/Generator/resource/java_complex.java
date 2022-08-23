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
    public void setTitle(String title) {
        this.title = title;
    }
    public String getTitle() {
        return this.title;
    }
    public void setDescription(String description) {
        this.description = description;
    }
    public String getDescription() {
        return this.description;
    }
    public void setType(String type) {
        this.type = type;
    }
    public String getType() {
        return this.type;
    }
    public void setNullable(boolean nullable) {
        this.nullable = nullable;
    }
    public boolean getNullable() {
        return this.nullable;
    }
    public void setDeprecated(boolean deprecated) {
        this.deprecated = deprecated;
    }
    public boolean getDeprecated() {
        return this.deprecated;
    }
    public void setReadonly(boolean readonly) {
        this.readonly = readonly;
    }
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

public class ScalarProperties {
    private String format;
    private Object _enum;
    private Object _default;
    public void setFormat(String format) {
        this.format = format;
    }
    public String getFormat() {
        return this.format;
    }
    public void setEnum(Object _enum) {
        this._enum = _enum;
    }
    public Object getEnum() {
        return this._enum;
    }
    public void setDefault(Object _default) {
        this._default = _default;
    }
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

import java.util.HashMap;

/**
 * Properties of a schema
 */
public class Properties extends HashMap<String, PropertyValue> {
}

/**
 * Properties specific for a container
 */
public class ContainerProperties {
    private String type;
    public void setType(String type) {
        this.type = type;
    }
    public String getType() {
        return this.type;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("type", this.type);
        return map;
    }
}

/**
 * Struct specific properties
 */
public class StructProperties {
    private Properties properties;
    private String[] required;
    public void setProperties(Properties properties) {
        this.properties = properties;
    }
    public Properties getProperties() {
        return this.properties;
    }
    public void setRequired(String[] required) {
        this.required = required;
    }
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

/**
 * Map specific properties
 */
public class MapProperties {
    private Object additionalProperties;
    private int maxProperties;
    private int minProperties;
    public void setAdditionalProperties(Object additionalProperties) {
        this.additionalProperties = additionalProperties;
    }
    public Object getAdditionalProperties() {
        return this.additionalProperties;
    }
    public void setMaxProperties(int maxProperties) {
        this.maxProperties = maxProperties;
    }
    public int getMaxProperties() {
        return this.maxProperties;
    }
    public void setMinProperties(int minProperties) {
        this.minProperties = minProperties;
    }
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

/**
 * Array properties
 */
public class ArrayProperties {
    private String type;
    private Object items;
    private int maxItems;
    private int minItems;
    private boolean uniqueItems;
    public void setType(String type) {
        this.type = type;
    }
    public String getType() {
        return this.type;
    }
    public void setItems(Object items) {
        this.items = items;
    }
    public Object getItems() {
        return this.items;
    }
    public void setMaxItems(int maxItems) {
        this.maxItems = maxItems;
    }
    public int getMaxItems() {
        return this.maxItems;
    }
    public void setMinItems(int minItems) {
        this.minItems = minItems;
    }
    public int getMinItems() {
        return this.minItems;
    }
    public void setUniqueItems(boolean uniqueItems) {
        this.uniqueItems = uniqueItems;
    }
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

/**
 * Boolean properties
 */
public class BooleanProperties {
    private String type;
    public void setType(String type) {
        this.type = type;
    }
    public String getType() {
        return this.type;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("type", this.type);
        return map;
    }
}

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
    public void setType(String type) {
        this.type = type;
    }
    public String getType() {
        return this.type;
    }
    public void setMultipleOf(float multipleOf) {
        this.multipleOf = multipleOf;
    }
    public float getMultipleOf() {
        return this.multipleOf;
    }
    public void setMaximum(float maximum) {
        this.maximum = maximum;
    }
    public float getMaximum() {
        return this.maximum;
    }
    public void setExclusiveMaximum(boolean exclusiveMaximum) {
        this.exclusiveMaximum = exclusiveMaximum;
    }
    public boolean getExclusiveMaximum() {
        return this.exclusiveMaximum;
    }
    public void setMinimum(float minimum) {
        this.minimum = minimum;
    }
    public float getMinimum() {
        return this.minimum;
    }
    public void setExclusiveMinimum(boolean exclusiveMinimum) {
        this.exclusiveMinimum = exclusiveMinimum;
    }
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

/**
 * String properties
 */
public class StringProperties {
    private String type;
    private int maxLength;
    private int minLength;
    private String pattern;
    public void setType(String type) {
        this.type = type;
    }
    public String getType() {
        return this.type;
    }
    public void setMaxLength(int maxLength) {
        this.maxLength = maxLength;
    }
    public int getMaxLength() {
        return this.maxLength;
    }
    public void setMinLength(int minLength) {
        this.minLength = minLength;
    }
    public int getMinLength() {
        return this.minLength;
    }
    public void setPattern(String pattern) {
        this.pattern = pattern;
    }
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

import java.util.HashMap;

/**
 * An object to hold mappings between payload values and schema names or references
 */
public class DiscriminatorMapping extends HashMap<String, String> {
}

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
public class Discriminator {
    private String propertyName;
    private DiscriminatorMapping mapping;
    public void setPropertyName(String propertyName) {
        this.propertyName = propertyName;
    }
    public String getPropertyName() {
        return this.propertyName;
    }
    public void setMapping(DiscriminatorMapping mapping) {
        this.mapping = mapping;
    }
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

/**
 * An intersection type combines multiple schemas into one
 */
public class AllOfProperties {
    private String description;
    private OfValue[] allOf;
    public void setDescription(String description) {
        this.description = description;
    }
    public String getDescription() {
        return this.description;
    }
    public void setAllOf(OfValue[] allOf) {
        this.allOf = allOf;
    }
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

/**
 * An union type can contain one of the provided schemas
 */
public class OneOfProperties {
    private String description;
    private Discriminator discriminator;
    private OfValue[] oneOf;
    public void setDescription(String description) {
        this.description = description;
    }
    public String getDescription() {
        return this.description;
    }
    public void setDiscriminator(Discriminator discriminator) {
        this.discriminator = discriminator;
    }
    public Discriminator getDiscriminator() {
        return this.discriminator;
    }
    public void setOneOf(OfValue[] oneOf) {
        this.oneOf = oneOf;
    }
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

import java.util.HashMap;
public class TemplateProperties extends HashMap<String, ReferenceType> {
}

/**
 * Represents a reference to another schema
 */
public class ReferenceType {
    private String ref;
    private TemplateProperties template;
    public void setRef(String ref) {
        this.ref = ref;
    }
    public String getRef() {
        return this.ref;
    }
    public void setTemplate(TemplateProperties template) {
        this.template = template;
    }
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

/**
 * Represents a generic type
 */
public class GenericType {
    private String generic;
    public void setGeneric(String generic) {
        this.generic = generic;
    }
    public String getGeneric() {
        return this.generic;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("$generic", this.generic);
        return map;
    }
}

import java.util.HashMap;

/**
 * Schema definitions which can be reused
 */
public class Definitions extends HashMap<String, DefinitionValue> {
}

import java.util.HashMap;

/**
 * Contains external definitions which are imported. The imported schemas can be used via the namespace
 */
public class Import extends HashMap<String, String> {
}

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
    public void setImport(Import _import) {
        this._import = _import;
    }
    public Import getImport() {
        return this._import;
    }
    public void setTitle(String title) {
        this.title = title;
    }
    public String getTitle() {
        return this.title;
    }
    public void setDescription(String description) {
        this.description = description;
    }
    public String getDescription() {
        return this.description;
    }
    public void setType(String type) {
        this.type = type;
    }
    public String getType() {
        return this.type;
    }
    public void setDefinitions(Definitions definitions) {
        this.definitions = definitions;
    }
    public Definitions getDefinitions() {
        return this.definitions;
    }
    public void setProperties(Properties properties) {
        this.properties = properties;
    }
    public Properties getProperties() {
        return this.properties;
    }
    public void setRequired(String[] required) {
        this.required = required;
    }
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
