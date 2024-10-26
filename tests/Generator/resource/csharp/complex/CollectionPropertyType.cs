using System.Text.Json.Serialization;

/// <summary>
/// Base collection property type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(MapPropertyType), typeDiscriminator: "map")]
[JsonDerivedType(typeof(ArrayPropertyType), typeDiscriminator: "array")]
public abstract class CollectionPropertyType : PropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

    [JsonPropertyName("schema")]
    public PropertyType? Schema { get; set; }

}

