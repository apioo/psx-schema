using System.Text.Json.Serialization;

/// <summary>
/// Base property type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(StringPropertyType), typeDiscriminator: "string")]
[JsonDerivedType(typeof(IntegerPropertyType), typeDiscriminator: "integer")]
[JsonDerivedType(typeof(NumberPropertyType), typeDiscriminator: "number")]
[JsonDerivedType(typeof(BooleanPropertyType), typeDiscriminator: "boolean")]
[JsonDerivedType(typeof(MapPropertyType), typeDiscriminator: "map")]
[JsonDerivedType(typeof(ArrayPropertyType), typeDiscriminator: "array")]
[JsonDerivedType(typeof(AnyPropertyType), typeDiscriminator: "any")]
[JsonDerivedType(typeof(GenericPropertyType), typeDiscriminator: "generic")]
[JsonDerivedType(typeof(ReferencePropertyType), typeDiscriminator: "reference")]
public abstract class PropertyType
{
    [JsonPropertyName("description")]
    public string? Description { get; set; }

    [JsonPropertyName("type")]
    public string? Type { get; set; }

    [JsonPropertyName("deprecated")]
    public bool? Deprecated { get; set; }

    [JsonPropertyName("nullable")]
    public bool? Nullable { get; set; }

}

