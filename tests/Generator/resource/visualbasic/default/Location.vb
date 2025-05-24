Imports System.Text.Json.Serialization

' Location of the person
Public Class Location
    <JsonPropertyName("lat")>
    Public Property Lat As Nullable(Double)

    <JsonPropertyName("long")>
    Public Property _Long As Nullable(Double)

End Class

