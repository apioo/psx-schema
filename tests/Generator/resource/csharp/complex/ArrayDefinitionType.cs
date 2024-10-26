using System.Text.Json.Serialization;

/// <summary>
/// Represents an array which contains a dynamic list of values
/// </summary>
public class ArrayDefinitionType : CollectionDefinitionType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

}

