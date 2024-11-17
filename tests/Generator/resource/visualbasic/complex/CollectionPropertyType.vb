Imports System.Text.Json.Serialization

' Base collection property type
Public Class CollectionPropertyType
    Inherits PropertyType
    <JsonPropertyName("schema")>
    Public Property Schema As PropertyType

    <JsonPropertyName("type")>
    Public Property Type As String

End Class

