using System.Text.Json.Serialization;

namespace TypeAPI.Model;

public class SecurityOAuth : Security
{
    [JsonPropertyName("authorizationUrl")]
    public string? AuthorizationUrl { get; set; }

    [JsonPropertyName("scopes")]
    public System.Collections.Generic.List<string>? Scopes { get; set; }

    [JsonPropertyName("tokenUrl")]
    public string? TokenUrl { get; set; }

}

