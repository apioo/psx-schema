Imports System.Text.Json.Serialization

Public Class RootSchema
    <JsonPropertyName("students")>
    Public Property Students As Nullable(StudentMap)

End Class

