import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;

/**
 * Represents a base type. Every type extends from this common type and shares the defined properties
 */
public class CommonType {
    private String description;
    private String type;
    private Boolean nullable;
    private Boolean deprecated;
    private Boolean readonly;
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
    public void setNullable(Boolean nullable) {
        this.nullable = nullable;
    }
    @JsonGetter("nullable")
    public Boolean getNullable() {
        return this.nullable;
    }
    @JsonSetter("deprecated")
    public void setDeprecated(Boolean deprecated) {
        this.deprecated = deprecated;
    }
    @JsonGetter("deprecated")
    public Boolean getDeprecated() {
        return this.deprecated;
    }
    @JsonSetter("readonly")
    public void setReadonly(Boolean readonly) {
        this.readonly = readonly;
    }
    @JsonGetter("readonly")
    public Boolean getReadonly() {
        return this.readonly;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;

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
import java.util.List;

/**
 * Represents an array type. An array type contains an ordered list of a specific type
 */
public class ArrayType extends CommonType {
    private String type;
    private Object items;
    private Integer maxItems;
    private Integer minItems;
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
    public void setMaxItems(Integer maxItems) {
        this.maxItems = maxItems;
    }
    @JsonGetter("maxItems")
    public Integer getMaxItems() {
        return this.maxItems;
    }
    @JsonSetter("minItems")
    public void setMinItems(Integer minItems) {
        this.minItems = minItems;
    }
    @JsonGetter("minItems")
    public Integer getMinItems() {
        return this.minItems;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;

/**
 * Represents a scalar type
 */
public class ScalarType extends CommonType {
    private String format;
    private List<Object> _enum;
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
    public void setEnum(List<Object> _enum) {
        this._enum = _enum;
    }
    @JsonGetter("enum")
    public List<Object> getEnum() {
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
import java.util.List;

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
import java.util.List;
import java.util.HashMap;

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
public class Discriminator {
    private String propertyName;
    private Map<String, String> mapping;
    @JsonSetter("propertyName")
    public void setPropertyName(String propertyName) {
        this.propertyName = propertyName;
    }
    @JsonGetter("propertyName")
    public String getPropertyName() {
        return this.propertyName;
    }
    @JsonSetter("mapping")
    public void setMapping(Map<String, String> mapping) {
        this.mapping = mapping;
    }
    @JsonGetter("mapping")
    public Map<String, String> getMapping() {
        return this.mapping;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;

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
import java.util.List;

/**
 * Represents an intersection type
 */
public class IntersectionType {
    private String description;
    private List<ReferenceType> allOf;
    @JsonSetter("description")
    public void setDescription(String description) {
        this.description = description;
    }
    @JsonGetter("description")
    public String getDescription() {
        return this.description;
    }
    @JsonSetter("allOf")
    public void setAllOf(List<ReferenceType> allOf) {
        this.allOf = allOf;
    }
    @JsonGetter("allOf")
    public List<ReferenceType> getAllOf() {
        return this.allOf;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;

/**
 * Represents a map type. A map type contains variable key value entries of a specific type
 */
public class MapType extends CommonType {
    private String type;
    private Object additionalProperties;
    private Integer maxProperties;
    private Integer minProperties;
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
    public void setMaxProperties(Integer maxProperties) {
        this.maxProperties = maxProperties;
    }
    @JsonGetter("maxProperties")
    public Integer getMaxProperties() {
        return this.maxProperties;
    }
    @JsonSetter("minProperties")
    public void setMinProperties(Integer minProperties) {
        this.minProperties = minProperties;
    }
    @JsonGetter("minProperties")
    public Integer getMinProperties() {
        return this.minProperties;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;

/**
 * Represents a number type (contains also integer)
 */
public class NumberType extends ScalarType {
    private String type;
    private Double multipleOf;
    private Double maximum;
    private Boolean exclusiveMaximum;
    private Double minimum;
    private Boolean exclusiveMinimum;
    @JsonSetter("type")
    public void setType(String type) {
        this.type = type;
    }
    @JsonGetter("type")
    public String getType() {
        return this.type;
    }
    @JsonSetter("multipleOf")
    public void setMultipleOf(Double multipleOf) {
        this.multipleOf = multipleOf;
    }
    @JsonGetter("multipleOf")
    public Double getMultipleOf() {
        return this.multipleOf;
    }
    @JsonSetter("maximum")
    public void setMaximum(Double maximum) {
        this.maximum = maximum;
    }
    @JsonGetter("maximum")
    public Double getMaximum() {
        return this.maximum;
    }
    @JsonSetter("exclusiveMaximum")
    public void setExclusiveMaximum(Boolean exclusiveMaximum) {
        this.exclusiveMaximum = exclusiveMaximum;
    }
    @JsonGetter("exclusiveMaximum")
    public Boolean getExclusiveMaximum() {
        return this.exclusiveMaximum;
    }
    @JsonSetter("minimum")
    public void setMinimum(Double minimum) {
        this.minimum = minimum;
    }
    @JsonGetter("minimum")
    public Double getMinimum() {
        return this.minimum;
    }
    @JsonSetter("exclusiveMinimum")
    public void setExclusiveMinimum(Boolean exclusiveMinimum) {
        this.exclusiveMinimum = exclusiveMinimum;
    }
    @JsonGetter("exclusiveMinimum")
    public Boolean getExclusiveMinimum() {
        return this.exclusiveMinimum;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;
import java.util.HashMap;

/**
 * Represents a reference type. A reference type points to a specific type at the definitions map
 */
public class ReferenceType {
    private String ref;
    private Map<String, String> template;
    @JsonSetter("$ref")
    public void setRef(String ref) {
        this.ref = ref;
    }
    @JsonGetter("$ref")
    public String getRef() {
        return this.ref;
    }
    @JsonSetter("$template")
    public void setTemplate(Map<String, String> template) {
        this.template = template;
    }
    @JsonGetter("$template")
    public Map<String, String> getTemplate() {
        return this.template;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;

/**
 * Represents a string type
 */
public class StringType extends ScalarType {
    private String type;
    private Integer maxLength;
    private Integer minLength;
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
    public void setMaxLength(Integer maxLength) {
        this.maxLength = maxLength;
    }
    @JsonGetter("maxLength")
    public Integer getMaxLength() {
        return this.maxLength;
    }
    @JsonSetter("minLength")
    public void setMinLength(Integer minLength) {
        this.minLength = minLength;
    }
    @JsonGetter("minLength")
    public Integer getMinLength() {
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
import java.util.List;
import java.util.HashMap;

/**
 * Represents a struct type. A struct type contains a fix set of defined properties
 */
public class StructType extends CommonType {
    private Boolean _final;
    private String _extends;
    private String type;
    private Map<String, Object> properties;
    private List<String> required;
    @JsonSetter("$final")
    public void setFinal(Boolean _final) {
        this._final = _final;
    }
    @JsonGetter("$final")
    public Boolean getFinal() {
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
    public void setProperties(Map<String, Object> properties) {
        this.properties = properties;
    }
    @JsonGetter("properties")
    public Map<String, Object> getProperties() {
        return this.properties;
    }
    @JsonSetter("required")
    public void setRequired(List<String> required) {
        this.required = required;
    }
    @JsonGetter("required")
    public List<String> getRequired() {
        return this.required;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;
import java.util.HashMap;

/**
 * The root TypeSchema
 */
public class TypeSchema {
    private Map<String, String> _import;
    private Map<String, Object> definitions;
    private String ref;
    @JsonSetter("$import")
    public void setImport(Map<String, String> _import) {
        this._import = _import;
    }
    @JsonGetter("$import")
    public Map<String, String> getImport() {
        return this._import;
    }
    @JsonSetter("definitions")
    public void setDefinitions(Map<String, Object> definitions) {
        this.definitions = definitions;
    }
    @JsonGetter("definitions")
    public Map<String, Object> getDefinitions() {
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;

/**
 * Represents an union type. An union type can contain one of the provided types
 */
public class UnionType {
    private String description;
    private Discriminator discriminator;
    private List<Object> oneOf;
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
    public void setOneOf(List<Object> oneOf) {
        this.oneOf = oneOf;
    }
    @JsonGetter("oneOf")
    public List<Object> getOneOf() {
        return this.oneOf;
    }
}
