using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Base collection property type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(ArrayPropertyType), typeDiscriminator: "array")]
[JsonDerivedType(typeof(MapPropertyType), typeDiscriminator: "map")]
public abstract class CollectionPropertyType : PropertyType
{
    [JsonPropertyName("schema")]
    public PropertyType? Schema { get; set; }

    [JsonPropertyName("type")]
    public new string? Type { get; set; }

}

