/// <summary>
/// Common properties which can be used at any schema
/// </summary>
public class CommonProperties
{
    public string Title { get; set; }
    public string Description { get; set; }
    public string Type { get; set; }
    public bool Nullable { get; set; }
    public bool Deprecated { get; set; }
    public bool Readonly { get; set; }
}

public class ScalarProperties
{
    public string Format { get; set; }
    public EnumValue Enum { get; set; }
    public ScalarValue Default { get; set; }
}

/// <summary>
/// Allowed values of an object property
/// </summary>
public class PropertyValue : object
{
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

/// <summary>
/// Properties of a schema
/// </summary>
public class Properties<string, PropertyValue> : IDictionary<string, PropertyValue>
{
}

/// <summary>
/// Properties specific for a container
/// </summary>
public class ContainerProperties
{
    public string Type { get; set; }
}

/// <summary>
/// Struct specific properties
/// </summary>
public class StructProperties
{
    public Properties Properties { get; set; }
    public string[] Required { get; set; }
}

/// <summary>
/// A struct contains a fix set of defined properties
/// </summary>
public class StructType : object
{
    private List<object> values = new List<object>();
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

/// <summary>
/// Map specific properties
/// </summary>
public class MapProperties
{
    public PropertyValue AdditionalProperties { get; set; }
    public int MaxProperties { get; set; }
    public int MinProperties { get; set; }
}

/// <summary>
/// A map contains variable key value entries of a specific type
/// </summary>
public class MapType : object
{
    private List<object> values = new List<object>();
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

/// <summary>
/// An object represents either a struct or map type
/// </summary>
public class ObjectType : object
{
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

/// <summary>
/// Allowed values of an array item
/// </summary>
public class ArrayValue : object
{
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

/// <summary>
/// Array properties
/// </summary>
public class ArrayProperties
{
    public string Type { get; set; }
    public ArrayValue Items { get; set; }
    public int MaxItems { get; set; }
    public int MinItems { get; set; }
    public bool UniqueItems { get; set; }
}

/// <summary>
/// An array contains an ordered list of a specific type
/// </summary>
public class ArrayType : object
{
    private List<object> values = new List<object>();
    public void addArrayType(CommonProperties value) {
        this.values.add(value);
    }
    public void addArrayType(ArrayProperties value) {
        this.values.add(value);
    }
    public List<object> getValues() {
        return this.values;
    }

/// <summary>
/// Boolean properties
/// </summary>
public class BooleanProperties
{
    public string Type { get; set; }
}

/// <summary>
/// Represents a boolean value
/// </summary>
public class BooleanType : object
{
    private List<object> values = new List<object>();
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

/// <summary>
/// Number properties
/// </summary>
public class NumberProperties
{
    public string Type { get; set; }
    public float MultipleOf { get; set; }
    public float Maximum { get; set; }
    public bool ExclusiveMaximum { get; set; }
    public float Minimum { get; set; }
    public bool ExclusiveMinimum { get; set; }
}

/// <summary>
/// Represents a number value (contains also integer)
/// </summary>
public class NumberType : object
{
    private List<object> values = new List<object>();
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

/// <summary>
/// String properties
/// </summary>
public class StringProperties
{
    public string Type { get; set; }
    public int MaxLength { get; set; }
    public int MinLength { get; set; }
    public string Pattern { get; set; }
}

/// <summary>
/// Represents a string value
/// </summary>
public class StringType : object
{
    private List<object> values = new List<object>();
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

/// <summary>
/// Allowed values in a combination schema
/// </summary>
public class OfValue : object
{
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

/// <summary>
/// An object to hold mappings between payload values and schema names or references
/// </summary>
public class DiscriminatorMapping<string, string> : IDictionary<string, string>
{
}

/// <summary>
/// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
/// </summary>
public class Discriminator
{
    public string PropertyName { get; set; }
    public DiscriminatorMapping Mapping { get; set; }
}

/// <summary>
/// An intersection type combines multiple schemas into one
/// </summary>
public class AllOfProperties
{
    public string Description { get; set; }
    public OfValue[] AllOf { get; set; }
}

/// <summary>
/// An union type can contain one of the provided schemas
/// </summary>
public class OneOfProperties
{
    public string Description { get; set; }
    public Discriminator Discriminator { get; set; }
    public OfValue[] OneOf { get; set; }
}

/// <summary>
/// A combination type is either a intersection or union type
/// </summary>
public class CombinationType : object
{
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

public class TemplateProperties<string, ReferenceType> : IDictionary<string, ReferenceType>
{
}

/// <summary>
/// Represents a reference to another schema
/// </summary>
public class ReferenceType
{
    public string Ref { get; set; }
    public TemplateProperties Template { get; set; }
}

/// <summary>
/// Represents a generic type
/// </summary>
public class GenericType
{
    public string Generic { get; set; }
}

/// <summary>
/// Represents a concrete type definition
/// </summary>
public class DefinitionValue : object
{
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

/// <summary>
/// Schema definitions which can be reused
/// </summary>
public class Definitions<string, DefinitionValue> : IDictionary<string, DefinitionValue>
{
}

/// <summary>
/// Contains external definitions which are imported. The imported schemas can be used via the namespace
/// </summary>
public class Import<string, string> : IDictionary<string, string>
{
}

/// <summary>
/// A list of possible enumeration values
/// </summary>
public class EnumValue : object
{
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

/// <summary>
/// Represents a scalar value
/// </summary>
public class ScalarValue : object
{
    private object value;
    public void setScalarValue(string value) {
        this.value = value;
    }
    public void setScalarValue(float value) {
        this.value = value;
    }
    public void setScalarValue(bool value) {
        this.value = value;
    }
    public object getValue() {
        return this.value;
    }
}

/// <summary>
/// TypeSchema meta schema which describes a TypeSchema
/// </summary>
public class TypeSchema
{
    public Import Import { get; set; }
    public string Title { get; set; }
    public string Description { get; set; }
    public string Type { get; set; }
    public Definitions Definitions { get; set; }
    public Properties Properties { get; set; }
    public string[] Required { get; set; }
}
