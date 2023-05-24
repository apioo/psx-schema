public class Creature
{
    public string Kind { get; set; }
}

public class Human extends Creature
{
    public string FirstName { get; set; }
}

public class Animal extends Creature
{
    public string Nickname { get; set; }
}

public class Union
{
    public object Union { get; set; }
    public object Intersection { get; set; }
    public object Discriminator { get; set; }
}
