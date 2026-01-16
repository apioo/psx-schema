using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Represents a map which contains a dynamic set of key value entries of the same type
/// </summary>
public class MapPropertyType : CollectionPropertyType
{
    [JsonPropertyName("type")]
    public new string? Type { get; set; } = "map";

}

