Imports System.Text.Json.Serialization

Public Class Human
    <JsonPropertyName("firstName")>
    Public Property FirstName As String

    <JsonPropertyName("parent")>
    Public Property Parent As Human

End Class

