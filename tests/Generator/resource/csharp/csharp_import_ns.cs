namespace Foo.Bar
{

using System.Text.Json.Serialization;
public class Import
{
    [JsonPropertyName("students")]
    public My.Import.StudentMap Students { get; set; }
    [JsonPropertyName("student")]
    public My.Import.Student Student { get; set; }
}
}

namespace Foo.Bar
{

using System.Text.Json.Serialization;
public class MyMap extends My.Import.Student
{
}
}
