using System.Text.Json.Serialization;
public class Human
{
    [JsonPropertyName("firstName")]
    public string? FirstName { get; set; }

    [JsonPropertyName("parent")]
    public Human? Parent { get; set; }

}

using System.Text.Json.Serialization;
public class Student : Human
{
    [JsonPropertyName("matricleNumber")]
    public string? MatricleNumber { get; set; }

}

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

using System.Text.Json.Serialization;
public class StudentMap : Map<Human, Student>
{
}

using System.Text.Json.Serialization;
public class HumanMap : Map<Human, Human>
{
}

using System.Text.Json.Serialization;
public class RootSchema
{
    [JsonPropertyName("students")]
    public StudentMap? Students { get; set; }

}
