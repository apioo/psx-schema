Imports System.Text.Json.Serialization

' Base collection property type
Public Class CollectionPropertyType
    Inherits PropertyType
    <JsonPropertyName("schema")>
    Public Property Schema As PropertyType

End Class

