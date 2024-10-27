Imports System.Text.Json.Serialization

Public Class SecurityApiKey
    Inherits Security
    <JsonPropertyName("name")>
    Public Property Name As String

    <JsonPropertyName("in")>
    Public Property _In As String

End Class

