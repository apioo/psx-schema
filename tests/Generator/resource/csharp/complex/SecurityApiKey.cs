using System.Text.Json.Serialization;

namespace TypeAPI.Model;

public class SecurityApiKey : Security
{
    [JsonPropertyName("name")]
    public string? Name { get; set; }

    [JsonPropertyName("in")]
    public string? In { get; set; }

}

