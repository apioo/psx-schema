Imports System.Text.Json.Serialization

' Base definition type
Public Class DefinitionType
    <JsonPropertyName("description")>
    Public Property Description As String

    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("deprecated")>
    Public Property Deprecated As Boolean

End Class

