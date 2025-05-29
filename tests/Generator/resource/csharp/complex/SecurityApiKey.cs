using System.Text.Json.Serialization;

namespace TypeAPI.Model;

public class SecurityApiKey : Security
{
    [JsonPropertyName("in")]
    public string? In { get; set; }

    [JsonPropertyName("name")]
    public string? Name { get; set; }

}

