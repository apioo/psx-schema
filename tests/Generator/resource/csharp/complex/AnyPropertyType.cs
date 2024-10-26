using System.Text.Json.Serialization;

/// <summary>
/// Represents an any value which allows any kind of value
/// </summary>
public class AnyPropertyType : PropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

}

