public class Human
{
    public string FirstName { get; set; }
}

public class Student extends Human
{
    public string MatricleNumber { get; set; }
}

public class StudentMap : Map<Student>
{
}

public class Map<T>
{
    public int TotalResults { get; set; }
    public T[] Entries { get; set; }
}

public class RootSchema
{
    public StudentMap Students { get; set; }
}
