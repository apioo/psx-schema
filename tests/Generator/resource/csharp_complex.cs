/// <summary>
/// Represents a base type. Every type extends from this common type and shares the defined properties
/// </summary>
public class CommonType
{
    public string Description { get; set; }
    public string Type { get; set; }
    public bool Nullable { get; set; }
    public bool Deprecated { get; set; }
    public bool Readonly { get; set; }
}

/// <summary>
/// Represents a struct type. A struct type contains a fix set of defined properties
/// </summary>
public class StructType extends CommonType
{
    public bool Final { get; set; }
    public string Extends { get; set; }
    public string Type { get; set; }
    public Properties Properties { get; set; }
    public string[] Required { get; set; }
}

using System.Collections.Generic;

/// <summary>
/// Properties of a struct
/// </summary>
public class Properties : Dictionary<string, object>
{
}

/// <summary>
/// Represents a map type. A map type contains variable key value entries of a specific type
/// </summary>
public class MapType extends CommonType
{
    public string Type { get; set; }
    public object AdditionalProperties { get; set; }
    public int MaxProperties { get; set; }
    public int MinProperties { get; set; }
}

/// <summary>
/// Represents an array type. An array type contains an ordered list of a specific type
/// </summary>
public class ArrayType extends CommonType
{
    public string Type { get; set; }
    public object Items { get; set; }
    public int MaxItems { get; set; }
    public int MinItems { get; set; }
}

/// <summary>
/// Represents a scalar type
/// </summary>
public class ScalarType extends CommonType
{
    public string Format { get; set; }
    public object[] Enum { get; set; }
    public object Default { get; set; }
}

/// <summary>
/// Represents a boolean type
/// </summary>
public class BooleanType extends ScalarType
{
    public string Type { get; set; }
}

/// <summary>
/// Represents a number type (contains also integer)
/// </summary>
public class NumberType extends ScalarType
{
    public string Type { get; set; }
    public float MultipleOf { get; set; }
    public float Maximum { get; set; }
    public bool ExclusiveMaximum { get; set; }
    public float Minimum { get; set; }
    public bool ExclusiveMinimum { get; set; }
}

/// <summary>
/// Represents a string type
/// </summary>
public class StringType extends ScalarType
{
    public string Type { get; set; }
    public int MaxLength { get; set; }
    public int MinLength { get; set; }
    public string Pattern { get; set; }
}

/// <summary>
/// Represents an any type
/// </summary>
public class AnyType extends CommonType
{
    public string Type { get; set; }
}

/// <summary>
/// Represents an intersection type
/// </summary>
public class IntersectionType
{
    public string Description { get; set; }
    public ReferenceType[] AllOf { get; set; }
}

/// <summary>
/// Represents an union type. An union type can contain one of the provided types
/// </summary>
public class UnionType
{
    public string Description { get; set; }
    public Discriminator Discriminator { get; set; }
    public object[] OneOf { get; set; }
}

using System.Collections.Generic;

/// <summary>
/// An object to hold mappings between payload values and schema names or references
/// </summary>
public class DiscriminatorMapping : Dictionary<string, string>
{
}

/// <summary>
/// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
/// </summary>
public class Discriminator
{
    public string PropertyName { get; set; }
    public DiscriminatorMapping Mapping { get; set; }
}

/// <summary>
/// Represents a reference type. A reference type points to a specific type at the definitions map
/// </summary>
public class ReferenceType
{
    public string Ref { get; set; }
    public TemplateProperties Template { get; set; }
}

using System.Collections.Generic;
public class TemplateProperties : Dictionary<string, string>
{
}

/// <summary>
/// Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
/// </summary>
public class GenericType
{
    public string Generic { get; set; }
}

using System.Collections.Generic;

/// <summary>
/// The definitions map which contains all types
/// </summary>
public class Definitions : Dictionary<string, object>
{
}

using System.Collections.Generic;

/// <summary>
/// Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. 'my_namespace:my_type'
/// </summary>
public class Import : Dictionary<string, string>
{
}

/// <summary>
/// The root TypeSchema
/// </summary>
public class TypeSchema
{
    public Import Import { get; set; }
    public Definitions Definitions { get; set; }
    public string Ref { get; set; }
}
