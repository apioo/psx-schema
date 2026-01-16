using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Represents a string value
/// </summary>
public class StringPropertyType : ScalarPropertyType
{
    [JsonPropertyName("default")]
    public string? Default { get; set; }

    [JsonPropertyName("format")]
    public string? Format { get; set; }

    [JsonPropertyName("type")]
    public new string? Type { get; set; } = "string";

}

