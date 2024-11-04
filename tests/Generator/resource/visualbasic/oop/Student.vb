Imports System.Text.Json.Serialization

Public Class Student
    Inherits HumanType
    <JsonPropertyName("matricleNumber")>
    Public Property MatricleNumber As String

End Class

