using System.Text.Json.Serialization;

public class Import
{
    [JsonPropertyName("students")]
    public StudentMap? Students { get; set; }

    [JsonPropertyName("student")]
    public Student? Student { get; set; }

}

