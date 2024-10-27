Imports System.Text.Json.Serialization

Public Class SecurityOAuth
    Inherits Security
    <JsonPropertyName("tokenUrl")>
    Public Property TokenUrl As String

    <JsonPropertyName("authorizationUrl")>
    Public Property AuthorizationUrl As String

    <JsonPropertyName("scopes")>
    Public Property Scopes As String()

End Class

