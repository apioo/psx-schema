using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// A struct represents a class/structure with a fix set of defined properties.
/// </summary>
public class StructDefinitionType : DefinitionType
{
    [JsonPropertyName("parent")]
    public ReferencePropertyType? Parent { get; set; }

    [JsonPropertyName("base")]
    public bool? Base { get; set; }

    [JsonPropertyName("properties")]
    public System.Collections.Generic.Dictionary<string, PropertyType>? Properties { get; set; }

    [JsonPropertyName("discriminator")]
    public string? Discriminator { get; set; }

    [JsonPropertyName("mapping")]
    public System.Collections.Generic.Dictionary<string, string>? Mapping { get; set; }

}

