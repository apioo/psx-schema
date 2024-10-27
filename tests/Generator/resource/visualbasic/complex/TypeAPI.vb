Imports System.Text.Json.Serialization

' The TypeAPI Root
Public Class TypeAPI
    Inherits TypeSchema
    <JsonPropertyName("baseUrl")>
    Public Property BaseUrl As String

    <JsonPropertyName("security")>
    Public Property Security As Security

    <JsonPropertyName("operations")>
    Public Property Operations As Dictionary(Of String, Operation)

End Class

