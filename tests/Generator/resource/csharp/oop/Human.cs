using System.Text.Json.Serialization;

public class Human
{
    [JsonPropertyName("firstName")]
    public string? FirstName { get; set; }

    [JsonPropertyName("parent")]
    public Human? Parent { get; set; }

}

