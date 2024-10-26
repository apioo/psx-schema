Imports System.Text.Json.Serialization

' Represents an array which contains a dynamic list of values
Public Class ArrayPropertyType
    Inherits CollectionPropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

