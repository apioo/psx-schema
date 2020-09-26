namespace Foo.Bar
{
public class Import
{
    public My.Import.StudentMap Students { get; set; }
    public My.Import.Student Student { get; set; }
}
}

namespace Foo.Bar
{
public class MyMap extends My.Import.Student
{
}
}
