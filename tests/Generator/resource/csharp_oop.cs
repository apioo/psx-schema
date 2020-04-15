public class Human
{
    public int FirstName { get; set; }
}

public class Student extends Human
{
    public int MatricleNumber { get; set; }
}


public class Map<T>
{
    public int TotalResults { get; set; }
    public T[] Entries { get; set; }
}

public class RootSchema
{
    public Map<Student> Students { get; set; }
}
