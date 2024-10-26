using System.Text.Json.Serialization;

/// <summary>
/// Represents a map which contains a dynamic set of key value entries
/// </summary>
public class MapDefinitionType : CollectionDefinitionType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

}

