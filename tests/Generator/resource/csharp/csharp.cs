using System.Text.Json.Serialization;

/// <summary>
/// Location of the person
/// </summary>
public class Location
{
    [JsonPropertyName("lat")]
    public float Lat { get; set; }
    [JsonPropertyName("long")]
    public float Long { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// An application
/// </summary>
public class Web
{
    [JsonPropertyName("name")]
    public string Name { get; set; }
    [JsonPropertyName("url")]
    public string Url { get; set; }
}

using System.Text.Json.Serialization;

/// <summary>
/// An simple author element with some description
/// </summary>
public class Author
{
    [JsonPropertyName("title")]
    public string Title { get; set; }
    [JsonPropertyName("email")]
    public string Email { get; set; }
    [JsonPropertyName("categories")]
    public string[] Categories { get; set; }
    [JsonPropertyName("locations")]
    public Location[] Locations { get; set; }
    [JsonPropertyName("origin")]
    public Location Origin { get; set; }
}

using System.Text.Json.Serialization;
using System.Collections.Generic;
public class Meta : Dictionary<string, string>
{
}

using System.Text.Json.Serialization;
using System.Collections.Generic;

/// <summary>
/// An general news entry
/// </summary>
public class News
{
    [JsonPropertyName("config")]
    public Meta Config { get; set; }
    [JsonPropertyName("inlineConfig")]
    public Dictionary<string, string> InlineConfig { get; set; }
    [JsonPropertyName("tags")]
    public string[] Tags { get; set; }
    [JsonPropertyName("receiver")]
    public Author[] Receiver { get; set; }
    [JsonPropertyName("resources")]
    public object[] Resources { get; set; }
    [JsonPropertyName("profileImage")]
    public string ProfileImage { get; set; }
    [JsonPropertyName("read")]
    public bool Read { get; set; }
    [JsonPropertyName("source")]
    public object Source { get; set; }
    [JsonPropertyName("author")]
    public Author Author { get; set; }
    [JsonPropertyName("meta")]
    public Meta Meta { get; set; }
    [JsonPropertyName("sendDate")]
    public string SendDate { get; set; }
    [JsonPropertyName("readDate")]
    public string ReadDate { get; set; }
    [JsonPropertyName("expires")]
    public string Expires { get; set; }
    [JsonPropertyName("price")]
    public float Price { get; set; }
    [JsonPropertyName("rating")]
    public int Rating { get; set; }
    [JsonPropertyName("content")]
    public string Content { get; set; }
    [JsonPropertyName("question")]
    public string Question { get; set; }
    [JsonPropertyName("version")]
    public string Version { get; set; }
    [JsonPropertyName("coffeeTime")]
    public string CoffeeTime { get; set; }
    [JsonPropertyName("profileUri")]
    public string ProfileUri { get; set; }
    [JsonPropertyName("g-recaptcha-response")]
    public string Captcha { get; set; }
    [JsonPropertyName("payload")]
    public object Payload { get; set; }
}
