Imports System.Text.Json.Serialization

Public Class HumanType
    <JsonPropertyName("firstName")>
    Public Property FirstName As String

    <JsonPropertyName("parent")>
    Public Property Parent As HumanType

End Class

