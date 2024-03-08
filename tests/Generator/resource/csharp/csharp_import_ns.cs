using System.Text.Json.Serialization;
namespace Foo.Bar;
public class Import
{
    [JsonPropertyName("students")]
    public My.Import.StudentMap? Students { get; set; }
    [JsonPropertyName("student")]
    public My.Import.Student? Student { get; set; }
}

using System.Text.Json.Serialization;
namespace Foo.Bar;
public class MyMap : My.Import.Student
{
}
