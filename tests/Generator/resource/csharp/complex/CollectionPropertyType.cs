using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Base collection property type
/// </summary>
public abstract class CollectionPropertyType : PropertyType
{
    [JsonPropertyName("schema")]
    public PropertyType? Schema { get; set; }

}

