Imports System.Text.Json.Serialization

' An simple author element with some description
Public Class Author
    <JsonPropertyName("title")>
    Public Property Title As String

    <JsonPropertyName("email")>
    Public Property Email As String

    <JsonPropertyName("categories")>
    Public Property Categories As String()

    <JsonPropertyName("locations")>
    Public Property Locations As Location()

    <JsonPropertyName("origin")>
    Public Property Origin As Location

End Class

