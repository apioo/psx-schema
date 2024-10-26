using System.Text.Json.Serialization;

/// <summary>
/// Location of the person
/// </summary>
public class Location
{
    [JsonPropertyName("lat")]
    public double? Lat { get; set; }

    [JsonPropertyName("long")]
    public double? Long { get; set; }

}

