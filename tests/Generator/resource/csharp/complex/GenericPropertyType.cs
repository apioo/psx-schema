using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Represents a generic value which can be replaced with a concrete type
/// </summary>
public class GenericPropertyType : PropertyType
{
    [JsonPropertyName("name")]
    public string? Name { get; set; }

    [JsonPropertyName("type")]
    public new string? Type { get; set; } = "generic";

}

