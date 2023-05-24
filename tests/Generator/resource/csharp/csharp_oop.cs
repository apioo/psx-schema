using System.Text.Json.Serialization;
public class Human
{
    [JsonPropertyName("firstName")]
    public string FirstName { get; set; }
}

using System.Text.Json.Serialization;
public class Student extends Human
{
    [JsonPropertyName("matricleNumber")]
    public string MatricleNumber { get; set; }
}

using System.Text.Json.Serialization;
public class StudentMap : Map<Student>
{
}

using System.Text.Json.Serialization;
public class Map<T>
{
    [JsonPropertyName("totalResults")]
    public int TotalResults { get; set; }
    [JsonPropertyName("entries")]
    public T[] Entries { get; set; }
}

using System.Text.Json.Serialization;
public class RootSchema
{
    [JsonPropertyName("students")]
    public StudentMap Students { get; set; }
}
