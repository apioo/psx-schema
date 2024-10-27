Imports System.Text.Json.Serialization

' Represents a string value
Public Class StringPropertyType
    Inherits ScalarPropertyType
    <JsonPropertyName("format")>
    Public Property Format As String

End Class

