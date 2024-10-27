Imports System.Text.Json.Serialization

' TypeSchema specification
Public Class TypeSchema
    <JsonPropertyName("import")>
    Public Property Import As Dictionary(Of String, String)

    <JsonPropertyName("definitions")>
    Public Property Definitions As Dictionary(Of String, DefinitionType)

    <JsonPropertyName("root")>
    Public Property Root As String

End Class

