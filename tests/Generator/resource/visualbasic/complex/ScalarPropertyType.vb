Imports System.Text.Json.Serialization

' Base scalar property type
Public Class ScalarPropertyType
    Inherits PropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

