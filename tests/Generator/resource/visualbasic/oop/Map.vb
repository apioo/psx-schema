Imports System.Text.Json.Serialization

Public Class Map(Of P, T)
    <JsonPropertyName("totalResults")>
    Public Property TotalResults As Nullable(Integer)

    <JsonPropertyName("parent")>
    Public Property Parent As Nullable(P)

    <JsonPropertyName("entries")>
    Public Property Entries As Nullable(T())

End Class

