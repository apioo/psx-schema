using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Describes the response of the operation
/// </summary>
public class Response
{
    [JsonPropertyName("code")]
    public int? Code { get; set; }

    [JsonPropertyName("contentType")]
    public string? ContentType { get; set; }

    [JsonPropertyName("schema")]
    public PropertyType? Schema { get; set; }

}

