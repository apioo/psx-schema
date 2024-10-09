using System.Text.Json.Serialization;

/// <summary>
/// Location of the person
/// </summary>
public class Location
{
    [JsonPropertyName("lat")]
    public double? Lat { get; set; }

    [JsonPropertyName("long")]
    public double? Long { get; set; }

}

using System.Text.Json.Serialization;

/// <summary>
/// An simple author element with some description
/// </summary>
public class Author
{
    [JsonPropertyName("title")]
    public string? Title { get; set; }

    [JsonPropertyName("email")]
    public string? Email { get; set; }

    [JsonPropertyName("categories")]
    public System.Collections.Generic.List<string>? Categories { get; set; }

    [JsonPropertyName("locations")]
    public System.Collections.Generic.List<Location>? Locations { get; set; }

    [JsonPropertyName("origin")]
    public Location? Origin { get; set; }

}

using System.Text.Json.Serialization;
using System.Collections.Generic;
public class Meta : Dictionary<string, string>
{
}

using System.Text.Json.Serialization;

/// <summary>
/// An general news entry
/// </summary>
public class News
{
    [JsonPropertyName("config")]
    public Meta? Config { get; set; }

    [JsonPropertyName("inlineConfig")]
    public System.Collections.Generic.Dictionary<string, string>? InlineConfig { get; set; }

    [JsonPropertyName("mapTags")]
    public System.Collections.Generic.Dictionary<string, string>? MapTags { get; set; }

    [JsonPropertyName("mapReceiver")]
    public System.Collections.Generic.Dictionary<string, Author>? MapReceiver { get; set; }

    [JsonPropertyName("tags")]
    public System.Collections.Generic.List<string>? Tags { get; set; }

    [JsonPropertyName("receiver")]
    public System.Collections.Generic.List<Author>? Receiver { get; set; }

    [JsonPropertyName("read")]
    public bool? Read { get; set; }

    [JsonPropertyName("author")]
    public Author? Author { get; set; }

    [JsonPropertyName("meta")]
    public Meta? Meta { get; set; }

    [JsonPropertyName("sendDate")]
    public System.DateOnly? SendDate { get; set; }

    [JsonPropertyName("readDate")]
    public System.DateTime? ReadDate { get; set; }

    [JsonPropertyName("price")]
    public double? Price { get; set; }

    [JsonPropertyName("rating")]
    public int? Rating { get; set; }

    [JsonPropertyName("content")]
    public string? Content { get; set; }

    [JsonPropertyName("question")]
    public string? Question { get; set; }

    [JsonPropertyName("version")]
    public string? Version { get; set; }

    [JsonPropertyName("coffeeTime")]
    public System.TimeOnly? CoffeeTime { get; set; }

    [JsonPropertyName("g-recaptcha-response")]
    public string? Captcha { get; set; }

    [JsonPropertyName("media.fields")]
    public string? MediaFields { get; set; }

    [JsonPropertyName("payload")]
    public object? Payload { get; set; }

}
