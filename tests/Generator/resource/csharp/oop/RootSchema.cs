using System.Text.Json.Serialization;

public class RootSchema
{
    [JsonPropertyName("students")]
    public StudentMap? Students { get; set; }

}

