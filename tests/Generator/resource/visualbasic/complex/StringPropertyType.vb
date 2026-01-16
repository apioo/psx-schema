Imports System.Text.Json.Serialization

' Represents a string value
Public Class StringPropertyType
    Inherits ScalarPropertyType
    <JsonPropertyName("default")>
    Public Property _Default As Nullable(String)

    <JsonPropertyName("format")>
    Public Property Format As Nullable(String)

    <JsonPropertyName("type")>
    Public Property Type As Nullable(String)

End Class

