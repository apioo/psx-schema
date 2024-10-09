using System.Text.Json.Serialization;

/// <summary>
/// Represents a base type. Every type extends from this common type and shares the defined properties
/// </summary>
public class CommonType
{
    [JsonPropertyName("description")]
    public string? Description { get; set; }
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("nullable")]
    public bool? Nullable { get; set; }
    [JsonPropertyName("deprecated")]
    public bool? Deprecated { get; set; }
    [JsonPropertyName("readonly")]
    public bool? Readonly { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents an any type
/// </summary>
public class AnyType : CommonType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents an array type. An array type contains an ordered list of a specific type
/// </summary>
public class ArrayType : CommonType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("items")]
    public object? Items { get; set; }
    [JsonPropertyName("maxItems")]
    public int? MaxItems { get; set; }
    [JsonPropertyName("minItems")]
    public int? MinItems { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a scalar type
/// </summary>
public class ScalarType : CommonType
{
    [JsonPropertyName("format")]
    public string? Format { get; set; }
    [JsonPropertyName("enum")]
    public System.Collections.Generic.List<object>? Enum { get; set; }
    [JsonPropertyName("default")]
    public object? Default { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a boolean type
/// </summary>
public class BooleanType : ScalarType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
}

using System.Text.Json.Serialization;
using System.Collections.Generic;

/// <summary>
/// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
/// </summary>
public class Discriminator
{
    [JsonPropertyName("propertyName")]
    public string? PropertyName { get; set; }
    [JsonPropertyName("mapping")]
    public System.Collections.Generic.Dictionary<string, string>? Mapping { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
/// </summary>
public class GenericType
{
    [JsonPropertyName("$generic")]
    public string? Generic { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents an intersection type
/// </summary>
public class IntersectionType
{
    [JsonPropertyName("description")]
    public string? Description { get; set; }
    [JsonPropertyName("allOf")]
    public System.Collections.Generic.List<ReferenceType>? AllOf { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a map type. A map type contains variable key value entries of a specific type
/// </summary>
public class MapType : CommonType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("additionalProperties")]
    public object? AdditionalProperties { get; set; }
    [JsonPropertyName("maxProperties")]
    public int? MaxProperties { get; set; }
    [JsonPropertyName("minProperties")]
    public int? MinProperties { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a number type (contains also integer)
/// </summary>
public class NumberType : ScalarType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("multipleOf")]
    public double? MultipleOf { get; set; }
    [JsonPropertyName("maximum")]
    public double? Maximum { get; set; }
    [JsonPropertyName("exclusiveMaximum")]
    public bool? ExclusiveMaximum { get; set; }
    [JsonPropertyName("minimum")]
    public double? Minimum { get; set; }
    [JsonPropertyName("exclusiveMinimum")]
    public bool? ExclusiveMinimum { get; set; }
}

using System.Text.Json.Serialization;
using System.Collections.Generic;

/// <summary>
/// Represents a reference type. A reference type points to a specific type at the definitions map
/// </summary>
public class ReferenceType
{
    [JsonPropertyName("$ref")]
    public string? Ref { get; set; }
    [JsonPropertyName("$template")]
    public System.Collections.Generic.Dictionary<string, string>? Template { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a string type
/// </summary>
public class StringType : ScalarType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("maxLength")]
    public int? MaxLength { get; set; }
    [JsonPropertyName("minLength")]
    public int? MinLength { get; set; }
    [JsonPropertyName("pattern")]
    public string? Pattern { get; set; }
}

using System.Text.Json.Serialization;
using System.Collections.Generic;

/// <summary>
/// Represents a struct type. A struct type contains a fix set of defined properties
/// </summary>
public class StructType : CommonType
{
    [JsonPropertyName("$final")]
    public bool? Final { get; set; }
    [JsonPropertyName("$extends")]
    public string? Extends { get; set; }
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("properties")]
    public System.Collections.Generic.Dictionary<string, object>? Properties { get; set; }
    [JsonPropertyName("required")]
    public System.Collections.Generic.List<string>? Required { get; set; }
}

using System.Text.Json.Serialization;
using System.Collections.Generic;

/// <summary>
/// The root TypeSchema
/// </summary>
public class TypeSchema
{
    [JsonPropertyName("$import")]
    public System.Collections.Generic.Dictionary<string, string>? Import { get; set; }
    [JsonPropertyName("definitions")]
    public System.Collections.Generic.Dictionary<string, object>? Definitions { get; set; }
    [JsonPropertyName("$ref")]
    public string? Ref { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents an union type. An union type can contain one of the provided types
/// </summary>
public class UnionType
{
    [JsonPropertyName("description")]
    public string? Description { get; set; }
    [JsonPropertyName("discriminator")]
    public Discriminator? Discriminator { get; set; }
    [JsonPropertyName("oneOf")]
    public System.Collections.Generic.List<object>? OneOf { get; set; }
}
