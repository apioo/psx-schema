Imports System.Text.Json.Serialization

Public Class SecurityOAuth
    Inherits Security
    <JsonPropertyName("authorizationUrl")>
    Public Property AuthorizationUrl As Nullable(String)

    <JsonPropertyName("scopes")>
    Public Property Scopes As Nullable(String())

    <JsonPropertyName("tokenUrl")>
    Public Property TokenUrl As Nullable(String)

End Class

