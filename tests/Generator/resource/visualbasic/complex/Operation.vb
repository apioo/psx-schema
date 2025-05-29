Imports System.Text.Json.Serialization

Public Class Operation
    <JsonPropertyName("arguments")>
    Public Property Arguments As Nullable(Dictionary(Of String, Argument))

    <JsonPropertyName("authorization")>
    Public Property Authorization As Nullable(Boolean)

    <JsonPropertyName("description")>
    Public Property Description As Nullable(String)

    <JsonPropertyName("method")>
    Public Property Method As Nullable(String)

    <JsonPropertyName("path")>
    Public Property Path As Nullable(String)

    <JsonPropertyName("return")>
    Public Property _Return As Nullable(Response)

    <JsonPropertyName("security")>
    Public Property Security As Nullable(String())

    <JsonPropertyName("stability")>
    Public Property Stability As Nullable(Integer)

    <JsonPropertyName("throws")>
    Public Property Throws As Nullable(Response())

End Class

