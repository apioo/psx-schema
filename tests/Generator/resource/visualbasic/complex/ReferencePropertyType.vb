Imports System.Text.Json.Serialization

' Represents a reference to a definition type
Public Class ReferencePropertyType
    Inherits PropertyType
    <JsonPropertyName("target")>
    Public Property Target As String

    <JsonPropertyName("template")>
    Public Property Template As Dictionary(Of String, String)

End Class

