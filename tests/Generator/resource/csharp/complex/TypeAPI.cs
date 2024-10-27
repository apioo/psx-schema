using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// The TypeAPI Root
/// </summary>
public class TypeAPI : TypeSchema
{
    [JsonPropertyName("baseUrl")]
    public string? BaseUrl { get; set; }

    [JsonPropertyName("security")]
    public Security? Security { get; set; }

    [JsonPropertyName("operations")]
    public System.Collections.Generic.Dictionary<string, Operation>? Operations { get; set; }

}

