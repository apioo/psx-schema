using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Represents an any value which allows any kind of value
/// </summary>
public class AnyPropertyType : PropertyType
{
    [JsonPropertyName("type")]
    public new string? Type { get; set; } = "any";

}

