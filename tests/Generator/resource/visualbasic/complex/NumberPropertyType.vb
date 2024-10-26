Imports System.Text.Json.Serialization

' Represents a float value
Public Class NumberPropertyType
    Inherits ScalarPropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

