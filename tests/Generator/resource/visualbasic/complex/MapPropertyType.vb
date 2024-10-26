Imports System.Text.Json.Serialization

' Represents a map which contains a dynamic set of key value entries
Public Class MapPropertyType
    Inherits CollectionPropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

