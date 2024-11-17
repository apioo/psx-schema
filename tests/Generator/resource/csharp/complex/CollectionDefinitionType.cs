using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Base collection type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(ArrayDefinitionType), typeDiscriminator: "array")]
[JsonDerivedType(typeof(MapDefinitionType), typeDiscriminator: "map")]
public abstract class CollectionDefinitionType : DefinitionType
{
    [JsonPropertyName("schema")]
    public PropertyType? Schema { get; set; }

    [JsonPropertyName("type")]
    public new string? Type { get; set; }

}

