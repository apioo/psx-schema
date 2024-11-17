Imports System.Text.Json.Serialization

' Base collection type
Public Class CollectionDefinitionType
    Inherits DefinitionType
    <JsonPropertyName("schema")>
    Public Property Schema As PropertyType

    <JsonPropertyName("type")>
    Public Property Type As String

End Class

