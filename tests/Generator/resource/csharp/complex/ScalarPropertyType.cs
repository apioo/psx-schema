using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Base scalar property type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(StringPropertyType), typeDiscriminator: "string")]
[JsonDerivedType(typeof(IntegerPropertyType), typeDiscriminator: "integer")]
[JsonDerivedType(typeof(NumberPropertyType), typeDiscriminator: "number")]
[JsonDerivedType(typeof(BooleanPropertyType), typeDiscriminator: "boolean")]
public abstract class ScalarPropertyType : PropertyType
{
}

