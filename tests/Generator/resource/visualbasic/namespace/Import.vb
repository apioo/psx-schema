Namespace Foo.Bar
Imports System.Text.Json.Serialization

Public Class Import
    <JsonPropertyName("students")>
    Public Property Students As Nullable(My.Import.StudentMap)

    <JsonPropertyName("student")>
    Public Property Student As Nullable(My.Import.Student)

End Class

End Namespace

