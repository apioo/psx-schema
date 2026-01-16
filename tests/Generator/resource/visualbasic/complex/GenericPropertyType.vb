Imports System.Text.Json.Serialization

' Represents a generic value which can be replaced with a concrete type
Public Class GenericPropertyType
    Inherits PropertyType
    <JsonPropertyName("name")>
    Public Property Name As Nullable(String)

    <JsonPropertyName("type")>
    Public Property Type As Nullable(String)

End Class

