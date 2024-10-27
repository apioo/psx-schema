using System.Text.Json.Serialization;

/// <summary>
/// Represents a string value
/// </summary>
public class StringPropertyType : ScalarPropertyType
{
    [JsonPropertyName("format")]
    public string? Format { get; set; }

}

