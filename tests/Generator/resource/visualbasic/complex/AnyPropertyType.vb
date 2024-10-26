Imports System.Text.Json.Serialization

' Represents an any value which allows any kind of value
Public Class AnyPropertyType
    Inherits PropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

