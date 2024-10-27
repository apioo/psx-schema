using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Base definition type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(StructDefinitionType), typeDiscriminator: "struct")]
[JsonDerivedType(typeof(MapDefinitionType), typeDiscriminator: "map")]
[JsonDerivedType(typeof(ArrayDefinitionType), typeDiscriminator: "array")]
public abstract class DefinitionType
{
    [JsonPropertyName("description")]
    public string? Description { get; set; }

    [JsonPropertyName("type")]
    public string? Type { get; set; }

    [JsonPropertyName("deprecated")]
    public bool? Deprecated { get; set; }

}

