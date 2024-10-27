Imports System.Text.Json.Serialization

' A struct represents a class/structure with a fix set of defined properties.
Public Class StructDefinitionType
    Inherits DefinitionType
    <JsonPropertyName("parent")>
    Public Property Parent As ReferencePropertyType

    <JsonPropertyName("base")>
    Public Property Base As Boolean

    <JsonPropertyName("properties")>
    Public Property Properties As Dictionary(Of String, PropertyType)

    <JsonPropertyName("discriminator")>
    Public Property Discriminator As String

    <JsonPropertyName("mapping")>
    Public Property Mapping As Dictionary(Of String, String)

End Class

