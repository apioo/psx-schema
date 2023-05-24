using System.Text.Json.Serialization;

/// <summary>
/// An application
/// </summary>
public class Web
{
    [JsonPropertyName("name")]
    public string Name { get; set; }
    [JsonPropertyName("url")]
    public string Url { get; set; }
}
