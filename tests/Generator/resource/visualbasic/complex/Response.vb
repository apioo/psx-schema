Imports System.Text.Json.Serialization

' Describes the response of the operation
Public Class Response
    <JsonPropertyName("code")>
    Public Property Code As Nullable(Integer)

    <JsonPropertyName("contentType")>
    Public Property ContentType As Nullable(String)

    <JsonPropertyName("schema")>
    Public Property Schema As Nullable(PropertyType)

End Class

