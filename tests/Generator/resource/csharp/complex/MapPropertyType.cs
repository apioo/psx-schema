using System.Text.Json.Serialization;

/// <summary>
/// Represents a map which contains a dynamic set of key value entries
/// </summary>
public class MapPropertyType : CollectionPropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

}

