using System.Text.Json.Serialization;
public class Creature
{
    [JsonPropertyName("kind")]
    public string Kind { get; set; }
}

using System.Text.Json.Serialization;
public class Human extends Creature
{
    [JsonPropertyName("firstName")]
    public string FirstName { get; set; }
}

using System.Text.Json.Serialization;
public class Animal extends Creature
{
    [JsonPropertyName("nickname")]
    public string Nickname { get; set; }
}

using System.Text.Json.Serialization;
public class Union
{
    [JsonPropertyName("union")]
    public object Union { get; set; }
    [JsonPropertyName("intersection")]
    public object Intersection { get; set; }
    [JsonPropertyName("discriminator")]
    public object Discriminator { get; set; }
}
