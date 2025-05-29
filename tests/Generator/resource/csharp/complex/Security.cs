using System.Text.Json.Serialization;

namespace TypeAPI.Model;

[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(SecurityApiKey), typeDiscriminator: "apiKey")]
[JsonDerivedType(typeof(SecurityHttpBasic), typeDiscriminator: "httpBasic")]
[JsonDerivedType(typeof(SecurityHttpBearer), typeDiscriminator: "httpBearer")]
[JsonDerivedType(typeof(SecurityOAuth), typeDiscriminator: "oauth2")]
public abstract class Security
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

}

