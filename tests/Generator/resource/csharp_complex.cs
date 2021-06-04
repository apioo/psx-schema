/// <summary>
/// Common properties which can be used at any schema
/// </summary>
public class CommonProperties
{
    public string Title { get; set; }
    public string Description { get; set; }
    public string Type { get; set; }
    public bool Nullable { get; set; }
    public bool Deprecated { get; set; }
    public bool Readonly { get; set; }
}

public class ScalarProperties
{
    public string Format { get; set; }
    public object Enum { get; set; }
    public object Default { get; set; }
}

using System.Collections.Generic;

/// <summary>
/// Properties of a schema
/// </summary>
public class Properties : Dictionary<string, PropertyValue>
{
}

/// <summary>
/// Properties specific for a container
/// </summary>
public class ContainerProperties
{
    public string Type { get; set; }
}

/// <summary>
/// Struct specific properties
/// </summary>
public class StructProperties
{
    public Properties Properties { get; set; }
    public string[] Required { get; set; }
}

/// <summary>
/// Map specific properties
/// </summary>
public class MapProperties
{
    public object AdditionalProperties { get; set; }
    public int MaxProperties { get; set; }
    public int MinProperties { get; set; }
}

/// <summary>
/// Array properties
/// </summary>
public class ArrayProperties
{
    public string Type { get; set; }
    public object Items { get; set; }
    public int MaxItems { get; set; }
    public int MinItems { get; set; }
    public bool UniqueItems { get; set; }
}

/// <summary>
/// Boolean properties
/// </summary>
public class BooleanProperties
{
    public string Type { get; set; }
}

/// <summary>
/// Number properties
/// </summary>
public class NumberProperties
{
    public string Type { get; set; }
    public float MultipleOf { get; set; }
    public float Maximum { get; set; }
    public bool ExclusiveMaximum { get; set; }
    public float Minimum { get; set; }
    public bool ExclusiveMinimum { get; set; }
}

/// <summary>
/// String properties
/// </summary>
public class StringProperties
{
    public string Type { get; set; }
    public int MaxLength { get; set; }
    public int MinLength { get; set; }
    public string Pattern { get; set; }
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
/// An intersection type combines multiple schemas into one
/// </summary>
public class AllOfProperties
{
    public string Description { get; set; }
    public OfValue[] AllOf { get; set; }
}

/// <summary>
/// An union type can contain one of the provided schemas
/// </summary>
public class OneOfProperties
{
    public string Description { get; set; }
    public Discriminator Discriminator { get; set; }
    public OfValue[] OneOf { get; set; }
}

using System.Collections.Generic;
public class TemplateProperties : Dictionary<string, ReferenceType>
{
}

/// <summary>
/// Represents a reference to another schema
/// </summary>
public class ReferenceType
{
    public string Ref { get; set; }
    public TemplateProperties Template { get; set; }
}

/// <summary>
/// Represents a generic type
/// </summary>
public class GenericType
{
    public string Generic { get; set; }
}

using System.Collections.Generic;

/// <summary>
/// Schema definitions which can be reused
/// </summary>
public class Definitions : Dictionary<string, DefinitionValue>
{
}

using System.Collections.Generic;

/// <summary>
/// Contains external definitions which are imported. The imported schemas can be used via the namespace
/// </summary>
public class Import : Dictionary<string, string>
{
}

/// <summary>
/// TypeSchema meta schema which describes a TypeSchema
/// </summary>
public class TypeSchema
{
    public Import Import { get; set; }
    public string Title { get; set; }
    public string Description { get; set; }
    public string Type { get; set; }
    public Definitions Definitions { get; set; }
    public Properties Properties { get; set; }
    public string[] Required { get; set; }
}
