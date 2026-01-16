using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Represents a boolean value
/// </summary>
public class BooleanPropertyType : ScalarPropertyType
{
    [JsonPropertyName("type")]
    public new string? Type { get; set; } = "boolean";

}

