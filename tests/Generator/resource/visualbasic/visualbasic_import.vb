Imports System.Text.Json.Serialization
Public Class Import
    <JsonPropertyName("students")>
    Public Property Students As StudentMap
    <JsonPropertyName("student")>
    Public Property Student As Student
End Class

Imports System.Text.Json.Serialization
Public Class MyMap
    Inherits Student
End Class
