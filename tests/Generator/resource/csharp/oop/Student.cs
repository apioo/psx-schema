using System.Text.Json.Serialization;

public class Student : Human
{
    [JsonPropertyName("matricleNumber")]
    public string? MatricleNumber { get; set; }

}

