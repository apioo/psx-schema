Imports System.Text.Json.Serialization

' Base type for the map and array collection type
Public Class CollectionDefinitionType
    Inherits DefinitionType
    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("schema")>
    Public Property Schema As PropertyType

End Class

