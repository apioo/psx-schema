Imports System.Text.Json.Serialization

' Represents a string value
Public Class StringPropertyType
    Inherits ScalarPropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("format")>
    Public Property Format As String

End Class

