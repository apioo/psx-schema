Imports System.Text.Json.Serialization

' Base collection type
Public Class CollectionDefinitionType
    Inherits DefinitionType
    <JsonPropertyName("schema")>
    Public Property Schema As PropertyType

End Class

