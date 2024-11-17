Imports System.Text.Json.Serialization

' Base definition type
Public Class DefinitionType
    <JsonPropertyName("deprecated")>
    Public Property Deprecated As Boolean

    <JsonPropertyName("description")>
    Public Property Description As String

    <JsonPropertyName("type")>
    Public Property Type As String

End Class

