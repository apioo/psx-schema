Imports System.Text.Json.Serialization

' Represents an integer value
Public Class IntegerPropertyType
    Inherits ScalarPropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

