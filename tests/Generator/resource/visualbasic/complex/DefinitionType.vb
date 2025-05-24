Imports System.Text.Json.Serialization

' Base definition type
Public Class DefinitionType
    <JsonPropertyName("deprecated")>
    Public Property Deprecated As Nullable(Boolean)

    <JsonPropertyName("description")>
    Public Property Description As Nullable(String)

    <JsonPropertyName("type")>
    Public Property Type As Nullable(String)

End Class

