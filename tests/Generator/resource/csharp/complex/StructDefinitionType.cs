using System.Text.Json.Serialization;

/// <summary>
/// Represents a struct which contains a fixed set of defined properties
/// </summary>
public class StructDefinitionType : DefinitionType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

    [JsonPropertyName("parent")]
    public string? Parent { get; set; }

    [JsonPropertyName("base")]
    public bool? Base { get; set; }

    [JsonPropertyName("properties")]
    public System.Collections.Generic.Dictionary<string, PropertyType>? Properties { get; set; }

    [JsonPropertyName("discriminator")]
    public string? Discriminator { get; set; }

    [JsonPropertyName("mapping")]
    public System.Collections.Generic.Dictionary<string, string>? Mapping { get; set; }

    [JsonPropertyName("template")]
    public System.Collections.Generic.Dictionary<string, string>? Template { get; set; }

}

