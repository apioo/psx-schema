Imports System.Text.Json.Serialization

' Base collection property type
Public Class CollectionPropertyType
    Inherits PropertyType
    <JsonPropertyName("schema")>
    Public Property Schema As Nullable(PropertyType)

    <JsonPropertyName("type")>
    Public Property Type As Nullable(String)

End Class

