Imports System.Text.Json.Serialization

' Base collection type
Public Class CollectionDefinitionType
    Inherits DefinitionType
    <JsonPropertyName("schema")>
    Public Property Schema As Nullable(PropertyType)

    <JsonPropertyName("type")>
    Public Property Type As Nullable(String)

End Class

