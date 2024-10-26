Imports System.Text.Json.Serialization

Public Class Student
    Inherits Human
    <JsonPropertyName("matricleNumber")>
    Public Property MatricleNumber As String

End Class

