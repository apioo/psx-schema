Imports System.Text.Json.Serialization

' Base property type
Public Class PropertyType
    <JsonPropertyName("description")>
    Public Property Description As String

    <JsonPropertyName("deprecated")>
    Public Property Deprecated As Boolean

    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("nullable")>
    Public Property Nullable As Boolean

End Class

