using System.Text.Json.Serialization;

namespace TypeAPI.Model;

public class Operation
{
    [JsonPropertyName("method")]
    public string? Method { get; set; }

    [JsonPropertyName("path")]
    public string? Path { get; set; }

    [JsonPropertyName("return")]
    public Response? Return { get; set; }

    [JsonPropertyName("arguments")]
    public System.Collections.Generic.Dictionary<string, Argument>? Arguments { get; set; }

    [JsonPropertyName("throws")]
    public System.Collections.Generic.List<Response>? Throws { get; set; }

    [JsonPropertyName("description")]
    public string? Description { get; set; }

    [JsonPropertyName("stability")]
    public int? Stability { get; set; }

    [JsonPropertyName("security")]
    public System.Collections.Generic.List<string>? Security { get; set; }

    [JsonPropertyName("authorization")]
    public bool? Authorization { get; set; }

    [JsonPropertyName("tags")]
    public System.Collections.Generic.List<string>? Tags { get; set; }

}

