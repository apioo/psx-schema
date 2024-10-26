using System.Text.Json.Serialization;

/// <summary>
/// Represents a reference to a definition type
/// </summary>
public class ReferencePropertyType : PropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

    [JsonPropertyName("target")]
    public string? Target { get; set; }

}

