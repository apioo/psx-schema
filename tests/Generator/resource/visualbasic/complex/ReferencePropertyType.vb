Imports System.Text.Json.Serialization

' Represents a reference to a definition type
Public Class ReferencePropertyType
    Inherits PropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("target")>
    Public Property Target As String

End Class

