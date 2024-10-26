using System.Text.Json.Serialization;

public class Specification
{
    [JsonPropertyName("import")]
    public System.Collections.Generic.Dictionary<string, string>? Import { get; set; }

    [JsonPropertyName("definitions")]
    public System.Collections.Generic.Dictionary<string, DefinitionType>? Definitions { get; set; }

    [JsonPropertyName("root")]
    public string? Root { get; set; }

}

