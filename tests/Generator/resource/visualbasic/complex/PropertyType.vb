Imports System.Text.Json.Serialization

' Base property type
Public Class PropertyType
    <JsonPropertyName("deprecated")>
    Public Property Deprecated As Nullable(Boolean)

    <JsonPropertyName("description")>
    Public Property Description As Nullable(String)

    <JsonPropertyName("nullable")>
    Public Property Nullable As Nullable(Boolean)

    <JsonPropertyName("type")>
    Public Property Type As Nullable(String)

End Class

