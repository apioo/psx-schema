Imports System.Text.Json.Serialization

Public Class Argument
    <JsonPropertyName("in")>
    Public Property _In As String

    <JsonPropertyName("schema")>
    Public Property Schema As PropertyType

    <JsonPropertyName("contentType")>
    Public Property ContentType As String

    <JsonPropertyName("name")>
    Public Property Name As String

End Class

