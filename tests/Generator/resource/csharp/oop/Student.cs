using System.Text.Json.Serialization;

public class Student : HumanType
{
    [JsonPropertyName("matricleNumber")]
    public string? MatricleNumber { get; set; }

}

