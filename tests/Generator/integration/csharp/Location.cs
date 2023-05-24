using System.Text.Json.Serialization;

/// <summary>
/// Location of the person
/// </summary>
public class Location
{
    [JsonPropertyName("lat")]
    public float Lat { get; set; }
    [JsonPropertyName("long")]
    public float Long { get; set; }
}
