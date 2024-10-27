using System.Text.Json.Serialization;

/// <summary>
/// Represents a reference to a definition type
/// </summary>
public class ReferencePropertyType : PropertyType
{
    [JsonPropertyName("target")]
    public string? Target { get; set; }

    [JsonPropertyName("template")]
    public System.Collections.Generic.Dictionary<string, string>? Template { get; set; }

}

