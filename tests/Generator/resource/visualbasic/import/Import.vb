Imports System.Text.Json.Serialization

Public Class Import
    <JsonPropertyName("students")>
    Public Property Students As Nullable(StudentMap)

    <JsonPropertyName("student")>
    Public Property Student As Nullable(Student)

End Class

