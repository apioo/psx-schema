Imports System.Text.Json.Serialization

' Represents an array which contains a dynamic list of values of the same type
Public Class ArrayDefinitionType
    Inherits CollectionDefinitionType
    <JsonPropertyName("type")>
    Public Property Type As Nullable(String)

End Class

