Imports System.Text.Json.Serialization

' Represents a reference to a definition type
Public Class ReferencePropertyType
    Inherits PropertyType
    <JsonPropertyName("target")>
    Public Property Target As Nullable(String)

    <JsonPropertyName("template")>
    Public Property Template As Nullable(Dictionary(Of String, String))

End Class

