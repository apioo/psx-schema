using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Represents an array which contains a dynamic list of values of the same type
/// </summary>
public class ArrayPropertyType : CollectionPropertyType
{
    [JsonPropertyName("type")]
    public new string? Type { get; set; } = "array";

}

