Imports System.Text.Json.Serialization

Public Class Operation
    <JsonPropertyName("method")>
    Public Property Method As String

    <JsonPropertyName("path")>
    Public Property Path As String

    <JsonPropertyName("return")>
    Public Property _Return As Response

    <JsonPropertyName("arguments")>
    Public Property Arguments As Dictionary(Of String, Argument)

    <JsonPropertyName("throws")>
    Public Property Throws As Response()

    <JsonPropertyName("description")>
    Public Property Description As String

    <JsonPropertyName("stability")>
    Public Property Stability As Integer

    <JsonPropertyName("security")>
    Public Property Security As String()

    <JsonPropertyName("authorization")>
    Public Property Authorization As Boolean

    <JsonPropertyName("tags")>
    Public Property Tags As String()

End Class

