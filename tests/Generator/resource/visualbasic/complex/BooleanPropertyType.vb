Imports System.Text.Json.Serialization

' Represents a boolean value
Public Class BooleanPropertyType
    Inherits ScalarPropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

