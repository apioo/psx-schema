/**
 * Common properties which can be used at any schema
 */
public static class CommonProperties {
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
}

public static class ScalarProperties {
    private String format;
    private EnumValue enum;
    private ScalarValue default;
    public void setFormat(String format) {
        this.format = format;
    }
    public String getFormat() {
        return this.format;
    }
    public void setEnum(EnumValue enum) {
        this.enum = enum;
    }
    public EnumValue getEnum() {
        return this.enum;
    }
    public void setDefault(ScalarValue default) {
        this.default = default;
    }
    public ScalarValue getDefault() {
        return this.default;
    }
}

/**
 * Allowed values of an object property
 */
public class PropertyValue {
    private object value;
    public void setPropertyValue(BooleanType value) {
        this.value = value;
    }
    public void setPropertyValue(NumberType value) {
        this.value = value;
    }
    public void setPropertyValue(StringType value) {
        this.value = value;
    }
    public void setPropertyValue(ArrayType value) {
        this.value = value;
    }
    public void setPropertyValue(CombinationType value) {
        this.value = value;
    }
    public void setPropertyValue(ReferenceType value) {
        this.value = value;
    }
    public void setPropertyValue(GenericType value) {
        this.value = value;
    }
    public object getValue() {
        return this.value;
    }
}

/**
 * Properties of a schema
 */
public static class Properties<String, PropertyValue> extends HashMap<String, PropertyValue> {
}

/**
 * Properties specific for a container
 */
public static class ContainerProperties {
    private String type;
    public void setType(String type) {
        this.type = type;
    }
    public String getType() {
        return this.type;
    }
}

/**
 * Struct specific properties
 */
public static class StructProperties {
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
}

/**
 * A struct contains a fix set of defined properties
 */
public class StructType {
    private List<object> values = new ArrayList<object>();
    public void addStructType(CommonProperties value) {
        this.values.add(value);
    }
    public void addStructType(ContainerProperties value) {
        this.values.add(value);
    }
    public void addStructType(StructProperties value) {
        this.values.add(value);
    }
    public List<object> getValues() {
        return this.values;
    }
}

/**
 * Map specific properties
 */
public static class MapProperties {
    private PropertyValue additionalProperties;
    private int maxProperties;
    private int minProperties;
    public void setAdditionalProperties(PropertyValue additionalProperties) {
        this.additionalProperties = additionalProperties;
    }
    public PropertyValue getAdditionalProperties() {
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
}

/**
 * A map contains variable key value entries of a specific type
 */
public class MapType {
    private List<object> values = new ArrayList<object>();
    public void addMapType(CommonProperties value) {
        this.values.add(value);
    }
    public void addMapType(ContainerProperties value) {
        this.values.add(value);
    }
    public void addMapType(MapProperties value) {
        this.values.add(value);
    }
    public List<object> getValues() {
        return this.values;
    }
}

/**
 * An object represents either a struct or map type
 */
public class ObjectType {
    private object value;
    public void setObjectType(StructType value) {
        this.value = value;
    }
    public void setObjectType(MapType value) {
        this.value = value;
    }
    public object getValue() {
        return this.value;
    }
}

/**
 * Allowed values of an array item
 */
public class ArrayValue {
    private object value;
    public void setArrayValue(BooleanType value) {
        this.value = value;
    }
    public void setArrayValue(NumberType value) {
        this.value = value;
    }
    public void setArrayValue(StringType value) {
        this.value = value;
    }
    public void setArrayValue(ReferenceType value) {
        this.value = value;
    }
    public void setArrayValue(GenericType value) {
        this.value = value;
    }
    public object getValue() {
        return this.value;
    }
}

/**
 * Array properties
 */
public static class ArrayProperties {
    private String type;
    private ArrayValue items;
    private int maxItems;
    private int minItems;
    private boolean uniqueItems;
    public void setType(String type) {
        this.type = type;
    }
    public String getType() {
        return this.type;
    }
    public void setItems(ArrayValue items) {
        this.items = items;
    }
    public ArrayValue getItems() {
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
}

/**
 * An array contains an ordered list of a specific type
 */
public class ArrayType {
    private List<object> values = new ArrayList<object>();
    public void addArrayType(CommonProperties value) {
        this.values.add(value);
    }
    public void addArrayType(ArrayProperties value) {
        this.values.add(value);
    }
    public List<object> getValues() {
        return this.values;
    }
}

/**
 * Boolean properties
 */
public static class BooleanProperties {
    private String type;
    public void setType(String type) {
        this.type = type;
    }
    public String getType() {
        return this.type;
    }
}

/**
 * Represents a boolean value
 */
public class BooleanType {
    private List<object> values = new ArrayList<object>();
    public void addBooleanType(CommonProperties value) {
        this.values.add(value);
    }
    public void addBooleanType(ScalarProperties value) {
        this.values.add(value);
    }
    public void addBooleanType(BooleanProperties value) {
        this.values.add(value);
    }
    public List<object> getValues() {
        return this.values;
    }
}

/**
 * Number properties
 */
public static class NumberProperties {
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
}

/**
 * Represents a number value (contains also integer)
 */
public class NumberType {
    private List<object> values = new ArrayList<object>();
    public void addNumberType(CommonProperties value) {
        this.values.add(value);
    }
    public void addNumberType(ScalarProperties value) {
        this.values.add(value);
    }
    public void addNumberType(NumberProperties value) {
        this.values.add(value);
    }
    public List<object> getValues() {
        return this.values;
    }
}

/**
 * String properties
 */
public static class StringProperties {
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
}

/**
 * Represents a string value
 */
public class StringType {
    private List<object> values = new ArrayList<object>();
    public void addStringType(CommonProperties value) {
        this.values.add(value);
    }
    public void addStringType(ScalarProperties value) {
        this.values.add(value);
    }
    public void addStringType(StringProperties value) {
        this.values.add(value);
    }
    public List<object> getValues() {
        return this.values;
    }
}

/**
 * Allowed values in a combination schema
 */
public class OfValue {
    private object value;
    public void setOfValue(NumberType value) {
        this.value = value;
    }
    public void setOfValue(StringType value) {
        this.value = value;
    }
    public void setOfValue(BooleanType value) {
        this.value = value;
    }
    public void setOfValue(ReferenceType value) {
        this.value = value;
    }
    public object getValue() {
        return this.value;
    }
}

/**
 * An object to hold mappings between payload values and schema names or references
 */
public static class DiscriminatorMapping<String, String> extends HashMap<String, String> {
}

/**
 * Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
 */
public static class Discriminator {
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
}

/**
 * An intersection type combines multiple schemas into one
 */
public static class AllOfProperties {
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
}

/**
 * An union type can contain one of the provided schemas
 */
public static class OneOfProperties {
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
}

/**
 * A combination type is either a intersection or union type
 */
public class CombinationType {
    private object value;
    public void setCombinationType(AllOfProperties value) {
        this.value = value;
    }
    public void setCombinationType(OneOfProperties value) {
        this.value = value;
    }
    public object getValue() {
        return this.value;
    }
}

public static class TemplateProperties<String, ReferenceType> extends HashMap<String, ReferenceType> {
}

/**
 * Represents a reference to another schema
 */
public static class ReferenceType {
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
}

/**
 * Represents a generic type
 */
public static class GenericType {
    private String generic;
    public void setGeneric(String generic) {
        this.generic = generic;
    }
    public String getGeneric() {
        return this.generic;
    }
}

/**
 * Represents a concrete type definition
 */
public class DefinitionValue {
    private object value;
    public void setDefinitionValue(ObjectType value) {
        this.value = value;
    }
    public void setDefinitionValue(ArrayType value) {
        this.value = value;
    }
    public void setDefinitionValue(BooleanType value) {
        this.value = value;
    }
    public void setDefinitionValue(NumberType value) {
        this.value = value;
    }
    public void setDefinitionValue(StringType value) {
        this.value = value;
    }
    public void setDefinitionValue(CombinationType value) {
        this.value = value;
    }
    public object getValue() {
        return this.value;
    }
}

/**
 * Schema definitions which can be reused
 */
public static class Definitions<String, DefinitionValue> extends HashMap<String, DefinitionValue> {
}

/**
 * Contains external definitions which are imported. The imported schemas can be used via the namespace
 */
public static class Import<String, String> extends HashMap<String, String> {
}

/**
 * A list of possible enumeration values
 */
public class EnumValue {
    private object value;
    public void setEnumValue(StringArray value) {
        this.value = value;
    }
    public void setEnumValue(NumberArray value) {
        this.value = value;
    }
    public object getValue() {
        return this.value;
    }
}

/**
 * Represents a scalar value
 */
public class ScalarValue {
    private object value;
    public void setScalarValue(String value) {
        this.value = value;
    }
    public void setScalarValue(float value) {
        this.value = value;
    }
    public void setScalarValue(boolean value) {
        this.value = value;
    }
    public object getValue() {
        return this.value;
    }
}

/**
 * TypeSchema meta schema which describes a TypeSchema
 */
public static class TypeSchema {
    private Import import;
    private String title;
    private String description;
    private String type;
    private Definitions definitions;
    private Properties properties;
    private String[] required;
    public void setImport(Import import) {
        this.import = import;
    }
    public Import getImport() {
        return this.import;
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
}
