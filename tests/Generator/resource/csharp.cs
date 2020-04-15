/// <summary>
/// Location of the person
/// </summary>
public class Location
{
    public float Lat { get; set; }
    public float Long { get; set; }
}

/// <summary>
/// An application
/// </summary>
public class Web
{
    public string Name { get; set; }
    public string Url { get; set; }
}

/// <summary>
/// An simple author element with some description
/// </summary>
public class Author
{
    public string Title { get; set; }
    public string Email { get; set; }
    public string[] Categories { get; set; }
    public Location[] Locations { get; set; }
    public Location Origin { get; set; }
}


/// <summary>
/// An general news entry
/// </summary>
public class RootSchema
{
    public Dictionary<string, string> Config { get; set; }
    public string[] Tags { get; set; }
    public Author[] Receiver { get; set; }
    public object[] Resources { get; set; }
    public string ProfileImage { get; set; }
    public bool Read { get; set; }
    public object Source { get; set; }
    public Author Author { get; set; }
    public Dictionary<string, string> Meta { get; set; }
    public string SendDate { get; set; }
    public string ReadDate { get; set; }
    public string Expires { get; set; }
    public float Price { get; set; }
    public int Rating { get; set; }
    public string Content { get; set; }
    public string Question { get; set; }
    public string Version { get; set; }
    public string CoffeeTime { get; set; }
    public string ProfileUri { get; set; }
    public string Captcha { get; set; }
}
