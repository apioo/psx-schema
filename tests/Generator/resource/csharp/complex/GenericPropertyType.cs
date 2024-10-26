using System.Text.Json.Serialization;

/// <summary>
/// Represents a generic value which can be replaced with a dynamic type
/// </summary>
public class GenericPropertyType : PropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

    [JsonPropertyName("name")]
    public string? Name { get; set; }

}

