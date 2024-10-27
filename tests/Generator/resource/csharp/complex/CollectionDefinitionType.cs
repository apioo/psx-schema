using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Base collection type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(MapDefinitionType), typeDiscriminator: "map")]
[JsonDerivedType(typeof(ArrayDefinitionType), typeDiscriminator: "array")]
public abstract class CollectionDefinitionType : DefinitionType
{
    [JsonPropertyName("schema")]
    public PropertyType? Schema { get; set; }

}

