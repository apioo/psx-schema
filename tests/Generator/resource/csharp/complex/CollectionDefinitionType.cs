using System.Text.Json.Serialization;

/// <summary>
/// Base type for the map and array collection type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(MapDefinitionType), typeDiscriminator: "map")]
[JsonDerivedType(typeof(ArrayDefinitionType), typeDiscriminator: "array")]
public abstract class CollectionDefinitionType : DefinitionType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

    [JsonPropertyName("schema")]
    public PropertyType? Schema { get; set; }

}

