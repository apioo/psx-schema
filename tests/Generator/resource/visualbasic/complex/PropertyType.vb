Imports System.Text.Json.Serialization

' Base property type
Public Class PropertyType
    <JsonPropertyName("deprecated")>
    Public Property Deprecated As Boolean

    <JsonPropertyName("description")>
    Public Property Description As String

    <JsonPropertyName("nullable")>
    Public Property Nullable As Boolean

    <JsonPropertyName("type")>
    Public Property Type As String

End Class

