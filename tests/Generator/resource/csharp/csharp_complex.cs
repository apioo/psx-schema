using System.Text.Json.Serialization;

/// <summary>
/// Represents a base type. Every type extends from this common type and shares the defined properties
/// </summary>
public class CommonType
{
    [JsonPropertyName("description")]
    public string Description { get; set; }
    [JsonPropertyName("type")]
    public string Type { get; set; }
    [JsonPropertyName("nullable")]
    public bool Nullable { get; set; }
    [JsonPropertyName("deprecated")]
    public bool Deprecated { get; set; }
    [JsonPropertyName("readonly")]
    public bool Readonly { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a struct type. A struct type contains a fix set of defined properties
/// </summary>
public class StructType extends CommonType
{
    [JsonPropertyName("$final")]
    public bool Final { get; set; }
    [JsonPropertyName("$extends")]
    public string Extends { get; set; }
    [JsonPropertyName("type")]
    public string Type { get; set; }
    [JsonPropertyName("properties")]
    public Properties Properties { get; set; }
    [JsonPropertyName("required")]
    public string[] Required { get; set; }
}

using System.Text.Json.Serialization;
using System.Collections.Generic;

/// <summary>
/// Properties of a struct
/// </summary>
public class Properties : Dictionary<string, object>
{
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a map type. A map type contains variable key value entries of a specific type
/// </summary>
public class MapType extends CommonType
{
    [JsonPropertyName("type")]
    public string Type { get; set; }
    [JsonPropertyName("additionalProperties")]
    public object AdditionalProperties { get; set; }
    [JsonPropertyName("maxProperties")]
    public int MaxProperties { get; set; }
    [JsonPropertyName("minProperties")]
    public int MinProperties { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents an array type. An array type contains an ordered list of a specific type
/// </summary>
public class ArrayType extends CommonType
{
    [JsonPropertyName("type")]
    public string Type { get; set; }
    [JsonPropertyName("items")]
    public object Items { get; set; }
    [JsonPropertyName("maxItems")]
    public int MaxItems { get; set; }
    [JsonPropertyName("minItems")]
    public int MinItems { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a scalar type
/// </summary>
public class ScalarType extends CommonType
{
    [JsonPropertyName("format")]
    public string Format { get; set; }
    [JsonPropertyName("enum")]
    public object[] Enum { get; set; }
    [JsonPropertyName("default")]
    public object Default { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a boolean type
/// </summary>
public class BooleanType extends ScalarType
{
    [JsonPropertyName("type")]
    public string Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a number type (contains also integer)
/// </summary>
public class NumberType extends ScalarType
{
    [JsonPropertyName("type")]
    public string Type { get; set; }
    [JsonPropertyName("multipleOf")]
    public float MultipleOf { get; set; }
    [JsonPropertyName("maximum")]
    public float Maximum { get; set; }
    [JsonPropertyName("exclusiveMaximum")]
    public bool ExclusiveMaximum { get; set; }
    [JsonPropertyName("minimum")]
    public float Minimum { get; set; }
    [JsonPropertyName("exclusiveMinimum")]
    public bool ExclusiveMinimum { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a string type
/// </summary>
public class StringType extends ScalarType
{
    [JsonPropertyName("type")]
    public string Type { get; set; }
    [JsonPropertyName("maxLength")]
    public int MaxLength { get; set; }
    [JsonPropertyName("minLength")]
    public int MinLength { get; set; }
    [JsonPropertyName("pattern")]
    public string Pattern { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents an any type
/// </summary>
public class AnyType extends CommonType
{
    [JsonPropertyName("type")]
    public string Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents an intersection type
/// </summary>
public class IntersectionType
{
    [JsonPropertyName("description")]
    public string Description { get; set; }
    [JsonPropertyName("allOf")]
    public ReferenceType[] AllOf { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents an union type. An union type can contain one of the provided types
/// </summary>
public class UnionType
{
    [JsonPropertyName("description")]
    public string Description { get; set; }
    [JsonPropertyName("discriminator")]
    public Discriminator Discriminator { get; set; }
    [JsonPropertyName("oneOf")]
    public object[] OneOf { get; set; }
}

using System.Text.Json.Serialization;
using System.Collections.Generic;

/// <summary>
/// An object to hold mappings between payload values and schema names or references
/// </summary>
public class DiscriminatorMapping : Dictionary<string, string>
{
}

using System.Text.Json.Serialization;

/// <summary>
/// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
/// </summary>
public class Discriminator
{
    [JsonPropertyName("propertyName")]
    public string PropertyName { get; set; }
    [JsonPropertyName("mapping")]
    public DiscriminatorMapping Mapping { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a reference type. A reference type points to a specific type at the definitions map
/// </summary>
public class ReferenceType
{
    [JsonPropertyName("$ref")]
    public string Ref { get; set; }
    [JsonPropertyName("$template")]
    public TemplateProperties Template { get; set; }
}

using System.Text.Json.Serialization;
using System.Collections.Generic;
public class TemplateProperties : Dictionary<string, string>
{
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
/// </summary>
public class GenericType
{
    [JsonPropertyName("$generic")]
    public string Generic { get; set; }
}

using System.Text.Json.Serialization;
using System.Collections.Generic;

/// <summary>
/// The definitions map which contains all types
/// </summary>
public class Definitions : Dictionary<string, object>
{
}

using System.Text.Json.Serialization;
using System.Collections.Generic;

/// <summary>
/// Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. 'my_namespace:my_type'
/// </summary>
public class Import : Dictionary<string, string>
{
}

using System.Text.Json.Serialization;

/// <summary>
/// The root TypeSchema
/// </summary>
public class TypeSchema
{
    [JsonPropertyName("$import")]
    public Import Import { get; set; }
    [JsonPropertyName("definitions")]
    public Definitions Definitions { get; set; }
    [JsonPropertyName("$ref")]
    public string Ref { get; set; }
}
