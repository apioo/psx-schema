Imports System.Text.Json.Serialization

Public Class HumanType
    <JsonPropertyName("firstName")>
    Public Property FirstName As Nullable(String)

    <JsonPropertyName("parent")>
    Public Property Parent As Nullable(HumanType)

End Class

