using System.Text.Json.Serialization;

/// <summary>
/// An simple author element with some description
/// </summary>
public class Author
{
    [JsonPropertyName("title")]
    public string Title { get; set; }
    [JsonPropertyName("email")]
    public string Email { get; set; }
    [JsonPropertyName("categories")]
    public string[] Categories { get; set; }
    [JsonPropertyName("locations")]
    public Location[] Locations { get; set; }
    [JsonPropertyName("origin")]
    public Location Origin { get; set; }
}
