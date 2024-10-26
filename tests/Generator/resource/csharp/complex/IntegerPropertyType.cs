using System.Text.Json.Serialization;

/// <summary>
/// Represents an integer value
/// </summary>
public class IntegerPropertyType : ScalarPropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

}

