Imports System.Text.Json.Serialization

' Represents a struct which contains a fixed set of defined properties
Public Class StructDefinitionType
    Inherits DefinitionType
    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("parent")>
    Public Property Parent As String

    <JsonPropertyName("base")>
    Public Property Base As Boolean

    <JsonPropertyName("properties")>
    Public Property Properties As Dictionary(Of String, PropertyType)

    <JsonPropertyName("discriminator")>
    Public Property Discriminator As String

    <JsonPropertyName("mapping")>
    Public Property Mapping As Dictionary(Of String, String)

    <JsonPropertyName("template")>
    Public Property Template As Dictionary(Of String, String)

End Class

