using System.Text.Json.Serialization;

namespace TypeAPI.Model;

/// <summary>
/// Base scalar property type
/// </summary>
[JsonPolymorphic(TypeDiscriminatorPropertyName = "type")]
[JsonDerivedType(typeof(BooleanPropertyType), typeDiscriminator: "boolean")]
[JsonDerivedType(typeof(IntegerPropertyType), typeDiscriminator: "integer")]
[JsonDerivedType(typeof(NumberPropertyType), typeDiscriminator: "number")]
[JsonDerivedType(typeof(StringPropertyType), typeDiscriminator: "string")]
public abstract class ScalarPropertyType : PropertyType
{
}

