using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Describes arguments of the operation
/// </summary>
public class Argument
{
    [JsonPropertyName("contentType")]
    public string? ContentType { get; set; }

    [JsonPropertyName("in")]
    public string? In { get; set; }

    [JsonPropertyName("name")]
    public string? Name { get; set; }

    [JsonPropertyName("schema")]
    public PropertyType? Schema { get; set; }

}

