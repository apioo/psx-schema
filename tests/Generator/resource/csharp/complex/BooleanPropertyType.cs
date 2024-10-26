using System.Text.Json.Serialization;

/// <summary>
/// Represents a boolean value
/// </summary>
public class BooleanPropertyType : ScalarPropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

}

