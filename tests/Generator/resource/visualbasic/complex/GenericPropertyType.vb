Imports System.Text.Json.Serialization

' Represents a generic value which can be replaced with a dynamic type
Public Class GenericPropertyType
    Inherits PropertyType
    <JsonPropertyName("name")>
    Public Property Name As Nullable(String)

End Class

