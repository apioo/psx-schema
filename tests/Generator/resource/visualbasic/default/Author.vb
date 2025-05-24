Imports System.Text.Json.Serialization

' An simple author element with some description
Public Class Author
    <JsonPropertyName("title")>
    Public Property Title As String

    <JsonPropertyName("email")>
    Public Property Email As Nullable(String)

    <JsonPropertyName("categories")>
    Public Property Categories As Nullable(String())

    <JsonPropertyName("locations")>
    Public Property Locations As Nullable(Location())

    <JsonPropertyName("origin")>
    Public Property Origin As Nullable(Location)

End Class

