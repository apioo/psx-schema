Imports System.Text.Json.Serialization

Public Class SecurityApiKey
    Inherits Security
    <JsonPropertyName("in")>
    Public Property _In As Nullable(String)

    <JsonPropertyName("name")>
    Public Property Name As Nullable(String)

End Class

