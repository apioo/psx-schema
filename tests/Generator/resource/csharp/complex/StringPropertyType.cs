using System.Text.Json.Serialization;

/// <summary>
/// Represents a string value
/// </summary>
public class StringPropertyType : ScalarPropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

    [JsonPropertyName("format")]
    public string? Format { get; set; }

}

