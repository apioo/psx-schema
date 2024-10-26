using System.Text.Json.Serialization;

public class Map<P, T>
{
    [JsonPropertyName("totalResults")]
    public int? TotalResults { get; set; }

    [JsonPropertyName("parent")]
    public P? Parent { get; set; }

    [JsonPropertyName("entries")]
    public System.Collections.Generic.List<T>? Entries { get; set; }

}

