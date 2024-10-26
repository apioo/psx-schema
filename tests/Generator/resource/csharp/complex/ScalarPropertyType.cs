using System.Text.Json.Serialization;

/// <summary>
/// Base scalar property type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(IntegerPropertyType), typeDiscriminator: "integer")]
[JsonDerivedType(typeof(NumberPropertyType), typeDiscriminator: "number")]
[JsonDerivedType(typeof(StringPropertyType), typeDiscriminator: "string")]
[JsonDerivedType(typeof(BooleanPropertyType), typeDiscriminator: "boolean")]
public abstract class ScalarPropertyType : PropertyType
{
    [JsonPropertyName("type")]
    public string? Type { get; set; }

}

