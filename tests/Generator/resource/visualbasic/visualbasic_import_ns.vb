Namespace Foo.Bar

Imports System.Text.Json.Serialization
Public Class Import
    <JsonPropertyName("students")>
    Public Property Students As My.Import.StudentMap

    <JsonPropertyName("student")>
    Public Property Student As My.Import.Student

End Class
End Namespace

Namespace Foo.Bar

Imports System.Text.Json.Serialization
Public Class MyMap
    Inherits My.Import.Student
End Class
End Namespace
