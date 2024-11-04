using System.Text.Json.Serialization;

public class HumanType
{
    [JsonPropertyName("firstName")]
    public string? FirstName { get; set; }

    [JsonPropertyName("parent")]
    public HumanType? Parent { get; set; }

}

