using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Base property type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(AnyPropertyType), typeDiscriminator: "any")]
[JsonDerivedType(typeof(ArrayPropertyType), typeDiscriminator: "array")]
[JsonDerivedType(typeof(BooleanPropertyType), typeDiscriminator: "boolean")]
[JsonDerivedType(typeof(GenericPropertyType), typeDiscriminator: "generic")]
[JsonDerivedType(typeof(IntegerPropertyType), typeDiscriminator: "integer")]
[JsonDerivedType(typeof(MapPropertyType), typeDiscriminator: "map")]
[JsonDerivedType(typeof(NumberPropertyType), typeDiscriminator: "number")]
[JsonDerivedType(typeof(ReferencePropertyType), typeDiscriminator: "reference")]
[JsonDerivedType(typeof(StringPropertyType), typeDiscriminator: "string")]
public abstract class PropertyType
{
    [JsonPropertyName("deprecated")]
    public bool? Deprecated { get; set; }

    [JsonPropertyName("description")]
    public string? Description { get; set; }

    [JsonPropertyName("nullable")]
    public bool? Nullable { get; set; }

    [JsonPropertyName("type")]
    public string? Type { get; set; }

}

