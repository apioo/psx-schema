Imports System.Text.Json.Serialization

' Describes arguments of the operation
Public Class Argument
    <JsonPropertyName("contentType")>
    Public Property ContentType As Nullable(String)

    <JsonPropertyName("in")>
    Public Property _In As Nullable(String)

    <JsonPropertyName("name")>
    Public Property Name As Nullable(String)

    <JsonPropertyName("schema")>
    Public Property Schema As Nullable(PropertyType)

End Class

