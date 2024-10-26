Imports System.Text.Json.Serialization

Public Class Map(Of P, T)
    <JsonPropertyName("totalResults")>
    Public Property TotalResults As Integer

    <JsonPropertyName("parent")>
    Public Property Parent As P

    <JsonPropertyName("entries")>
    Public Property Entries As T()

End Class

