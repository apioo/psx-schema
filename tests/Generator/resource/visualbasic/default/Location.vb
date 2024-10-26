Imports System.Text.Json.Serialization

' Location of the person
Public Class Location
    <JsonPropertyName("lat")>
    Public Property Lat As Double

    <JsonPropertyName("long")>
    Public Property _Long As Double

End Class

