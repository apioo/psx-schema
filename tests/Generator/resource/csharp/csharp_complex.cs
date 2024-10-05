using System.Text.Json.Serialization;

/// <summary>
/// Base definition type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(StructDefinitionType), typeDiscriminator: "struct")]
[JsonDerivedType(typeof(MapDefinitionType), typeDiscriminator: "map")]
[JsonDerivedType(typeof(ArrayDefinitionType), typeDiscriminator: "array")]
public class DefinitionType
{
    [JsonPropertyName("description")]
    public string? Description { get; set; }
    [JsonPropertyName("deprecated")]
    public bool? Deprecated { get; set; }
    [JsonPropertyName("type")]
    public string? Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a struct which contains a fixed set of defined properties
/// </summary>
public class StructDefinitionType : DefinitionType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("parent")]
    public string? Parent { get; set; }
    [JsonPropertyName("base")]
    public bool? Base { get; set; }
    [JsonPropertyName("properties")]
    public System.Collections.Generic.Dictionary<string, PropertyType>? Properties { get; set; }
    [JsonPropertyName("discriminator")]
    public string? Discriminator { get; set; }
    [JsonPropertyName("mapping")]
    public System.Collections.Generic.Dictionary<string, string>? Mapping { get; set; }
    [JsonPropertyName("template")]
    public System.Collections.Generic.Dictionary<string, string>? Template { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Base type for the map and array collection type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(MapDefinitionType), typeDiscriminator: "map")]
[JsonDerivedType(typeof(ArrayDefinitionType), typeDiscriminator: "array")]
public class CollectionDefinitionType : DefinitionType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("schema")]
    public PropertyType? Schema { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a map which contains a dynamic set of key value entries
/// </summary>
public class MapDefinitionType : CollectionDefinitionType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents an array which contains a dynamic list of values
/// </summary>
public class ArrayDefinitionType : CollectionDefinitionType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Base property type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(IntegerPropertyType), typeDiscriminator: "integer")]
[JsonDerivedType(typeof(NumberPropertyType), typeDiscriminator: "number")]
[JsonDerivedType(typeof(StringPropertyType), typeDiscriminator: "string")]
[JsonDerivedType(typeof(BooleanPropertyType), typeDiscriminator: "boolean")]
[JsonDerivedType(typeof(MapPropertyType), typeDiscriminator: "map")]
[JsonDerivedType(typeof(ArrayPropertyType), typeDiscriminator: "array")]
[JsonDerivedType(typeof(AnyPropertyType), typeDiscriminator: "any")]
[JsonDerivedType(typeof(GenericPropertyType), typeDiscriminator: "generic")]
[JsonDerivedType(typeof(ReferencePropertyType), typeDiscriminator: "reference")]
public class PropertyType
{
    [JsonPropertyName("description")]
    public string? Description { get; set; }
    [JsonPropertyName("deprecated")]
    public bool? Deprecated { get; set; }
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("nullable")]
    public bool? Nullable { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Base scalar property type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(IntegerPropertyType), typeDiscriminator: "integer")]
[JsonDerivedType(typeof(NumberPropertyType), typeDiscriminator: "number")]
[JsonDerivedType(typeof(StringPropertyType), typeDiscriminator: "string")]
[JsonDerivedType(typeof(BooleanPropertyType), typeDiscriminator: "boolean")]
public class ScalarPropertyType : PropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents an integer value
/// </summary>
public class IntegerPropertyType : ScalarPropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a float value
/// </summary>
public class NumberPropertyType : ScalarPropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a string value
/// </summary>
public class StringPropertyType : ScalarPropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("format")]
    public string? Format { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a boolean value
/// </summary>
public class BooleanPropertyType : ScalarPropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Base collection property type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(MapPropertyType), typeDiscriminator: "map")]
[JsonDerivedType(typeof(ArrayPropertyType), typeDiscriminator: "array")]
public class CollectionPropertyType : PropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("schema")]
    public PropertyType? Schema { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a map which contains a dynamic set of key value entries
/// </summary>
public class MapPropertyType : CollectionPropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents an array which contains a dynamic list of values
/// </summary>
public class ArrayPropertyType : CollectionPropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents an any value which allows any kind of value
/// </summary>
public class AnyPropertyType : PropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a generic value which can be replaced with a dynamic type
/// </summary>
public class GenericPropertyType : PropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("name")]
    public string? Name { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// Represents a reference to a definition type
/// </summary>
public class ReferencePropertyType : PropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }
    [JsonPropertyName("target")]
    public string? Target { get; set; }
}

using System.Text.Json.Serialization;
public class Specification
{
    [JsonPropertyName("import")]
    public System.Collections.Generic.Dictionary<string, string>? Import { get; set; }
    [JsonPropertyName("definitions")]
    public System.Collections.Generic.Dictionary<string, DefinitionType>? Definitions { get; set; }
    [JsonPropertyName("root")]
    public string? Root { get; set; }
}
