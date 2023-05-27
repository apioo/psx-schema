Imports System.Text.Json.Serialization
Public Class Human
    <JsonPropertyName("firstName")>
    Public Property FirstName As String
End Class

Imports System.Text.Json.Serialization
Public Class Student
    Inherits Human
    <JsonPropertyName("matricleNumber")>
    Public Property MatricleNumber As String
End Class

Imports System.Text.Json.Serialization
Public Class StudentMap : Map(Student)
    Inherits Map(Student)
End Class

Imports System.Text.Json.Serialization
Public Class Map(Of T)
    <JsonPropertyName("totalResults")>
    Public Property TotalResults As Integer
    <JsonPropertyName("entries")>
    Public Property Entries As T()
End Class

Imports System.Text.Json.Serialization
Public Class RootSchema
    <JsonPropertyName("students")>
    Public Property Students As StudentMap
End Class
