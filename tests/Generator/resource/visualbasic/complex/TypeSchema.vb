Imports System.Text.Json.Serialization

' TypeSchema specification
Public Class TypeSchema
    <JsonPropertyName("definitions")>
    Public Property Definitions As Nullable(Dictionary(Of String, DefinitionType))

    <JsonPropertyName("import")>
    Public Property Import As Nullable(Dictionary(Of String, String))

    <JsonPropertyName("root")>
    Public Property Root As Nullable(String)

End Class

