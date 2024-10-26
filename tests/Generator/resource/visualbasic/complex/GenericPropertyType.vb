Imports System.Text.Json.Serialization

' Represents a generic value which can be replaced with a dynamic type
Public Class GenericPropertyType
    Inherits PropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("name")>
    Public Property Name As String

End Class

