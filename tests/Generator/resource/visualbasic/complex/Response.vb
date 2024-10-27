Imports System.Text.Json.Serialization

Public Class Response
    <JsonPropertyName("code")>
    Public Property Code As Integer

    <JsonPropertyName("contentType")>
    Public Property ContentType As String

    <JsonPropertyName("schema")>
    Public Property Schema As PropertyType

End Class

