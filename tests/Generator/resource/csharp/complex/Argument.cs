using System.Text.Json.Serialization;

namespace TypeAPI.Model;

public class Argument
{
    [JsonPropertyName("in")]
    public string? In { get; set; }

    [JsonPropertyName("schema")]
    public PropertyType? Schema { get; set; }

    [JsonPropertyName("contentType")]
    public string? ContentType { get; set; }

    [JsonPropertyName("name")]
    public string? Name { get; set; }

}

