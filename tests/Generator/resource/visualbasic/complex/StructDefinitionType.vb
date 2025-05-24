Imports System.Text.Json.Serialization

' A struct represents a class/structure with a fix set of defined properties.
Public Class StructDefinitionType
    Inherits DefinitionType
    <JsonPropertyName("base")>
    Public Property Base As Nullable(Boolean)

    <JsonPropertyName("discriminator")>
    Public Property Discriminator As Nullable(String)

    <JsonPropertyName("mapping")>
    Public Property Mapping As Nullable(Dictionary(Of String, String))

    <JsonPropertyName("parent")>
    Public Property Parent As Nullable(ReferencePropertyType)

    <JsonPropertyName("properties")>
    Public Property Properties As Nullable(Dictionary(Of String, PropertyType))

End Class

