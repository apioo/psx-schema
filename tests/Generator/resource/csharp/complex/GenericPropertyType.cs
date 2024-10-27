using System.Text.Json.Serialization;

/// <summary>
/// Represents a generic value which can be replaced with a dynamic type
/// </summary>
public class GenericPropertyType : PropertyType
{
    [JsonPropertyName("name")]
    public string? Name { get; set; }

}

