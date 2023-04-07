import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a base type. Every type extends from this common type and shares the defined properties
 */
public class CommonType {
    private String description;
    private String type;
    private boolean nullable;
    private boolean deprecated;
    private boolean readonly;
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
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a struct type. A struct type contains a fix set of defined properties
 */
public class StructType extends CommonType {
    private boolean _final;
    private String _extends;
    private String type;
    private Properties properties;
    private String[] required;
    @JsonSetter("$final")
    public void setFinal(boolean _final) {
        this._final = _final;
    }
    @JsonGetter("$final")
    public boolean getFinal() {
        return this._final;
    }
    @JsonSetter("$extends")
    public void setExtends(String _extends) {
        this._extends = _extends;
    }
    @JsonGetter("$extends")
    public String getExtends() {
        return this._extends;
    }
    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonGetter("type")
    public String getType() {
        return this.type;
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
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.HashMap;

/**
 * Properties of a struct
 */
public class Properties extends HashMap<String, Object> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a map type. A map type contains variable key value entries of a specific type
 */
public class MapType extends CommonType {
    private String type;
    private Object additionalProperties;
    private int maxProperties;
    private int minProperties;
    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
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
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents an array type. An array type contains an ordered list of a specific type
 */
public class ArrayType extends CommonType {
    private String type;
    private Object items;
    private int maxItems;
    private int minItems;
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
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a scalar type
 */
public class ScalarType extends CommonType {
    private String format;
    private Object[] _enum;
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
    public void setEnum(Object[] _enum) {
        this._enum = _enum;
    }
    @JsonGetter("enum")
    public Object[] getEnum() {
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
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a boolean type
 */
public class BooleanType extends ScalarType {
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
 * Represents a number type (contains also integer)
 */
public class NumberType extends ScalarType {
    private String type;
    private double multipleOf;
    private double maximum;
    private boolean exclusiveMaximum;
    private double minimum;
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
    public void setMultipleOf(double multipleOf) {
        this.multipleOf = multipleOf;
    }
    @JsonGetter("multipleOf")
    public double getMultipleOf() {
        return this.multipleOf;
    }
    @JsonSetter("maximum")
    public void setMaximum(double maximum) {
        this.maximum = maximum;
    }
    @JsonGetter("maximum")
    public double getMaximum() {
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
    public void setMinimum(double minimum) {
        this.minimum = minimum;
    }
    @JsonGetter("minimum")
    public double getMinimum() {
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
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a string type
 */
public class StringType extends ScalarType {
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
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents an any type
 */
public class AnyType extends CommonType {
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
 * Represents an intersection type
 */
public class IntersectionType {
    private String description;
    private ReferenceType[] allOf;
    @JsonSetter("description")
    public void setDescription(String description) {
        this.description = description;
    }
    @JsonGetter("description")
    public String getDescription() {
        return this.description;
    }
    @JsonSetter("allOf")
    public void setAllOf(ReferenceType[] allOf) {
        this.allOf = allOf;
    }
    @JsonGetter("allOf")
    public ReferenceType[] getAllOf() {
        return this.allOf;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents an union type. An union type can contain one of the provided types
 */
public class UnionType {
    private String description;
    private Discriminator discriminator;
    private Object[] oneOf;
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
    public void setOneOf(Object[] oneOf) {
        this.oneOf = oneOf;
    }
    @JsonGetter("oneOf")
    public Object[] getOneOf() {
        return this.oneOf;
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
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a reference type. A reference type points to a specific type at the definitions map
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
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.HashMap;
public class TemplateProperties extends HashMap<String, String> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
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
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.HashMap;

/**
 * The definitions map which contains all types
 */
public class Definitions extends HashMap<String, Object> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.HashMap;

/**
 * Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. 'my_namespace:my_type'
 */
public class Import extends HashMap<String, String> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * The root TypeSchema
 */
public class TypeSchema {
    private Import _import;
    private Definitions definitions;
    private String ref;
    @JsonSetter("$import")
    public void setImport(Import _import) {
        this._import = _import;
    }
    @JsonGetter("$import")
    public Import getImport() {
        return this._import;
    }
    @JsonSetter("definitions")
    public void setDefinitions(Definitions definitions) {
        this.definitions = definitions;
    }
    @JsonGetter("definitions")
    public Definitions getDefinitions() {
        return this.definitions;
    }
    @JsonSetter("$ref")
    public void setRef(String ref) {
        this.ref = ref;
    }
    @JsonGetter("$ref")
    public String getRef() {
        return this.ref;
    }
}
