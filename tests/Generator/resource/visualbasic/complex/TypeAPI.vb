Imports System.Text.Json.Serialization

' The TypeAPI Root
Public Class TypeAPI
    Inherits TypeSchema
    <JsonPropertyName("baseUrl")>
    Public Property BaseUrl As Nullable(String)

    <JsonPropertyName("operations")>
    Public Property Operations As Nullable(Dictionary(Of String, Operation))

    <JsonPropertyName("security")>
    Public Property Security As Nullable(Security)

End Class

