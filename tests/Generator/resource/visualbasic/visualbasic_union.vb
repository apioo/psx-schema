Imports System.Text.Json.Serialization
Public Class Creature
    <JsonPropertyName("kind")>
    Public Property Kind As String
End Class

Imports System.Text.Json.Serialization
Public Class Human
    Inherits Creature
    <JsonPropertyName("firstName")>
    Public Property FirstName As String
End Class

Imports System.Text.Json.Serialization
Public Class Animal
    Inherits Creature
    <JsonPropertyName("nickname")>
    Public Property Nickname As String
End Class

Imports System.Text.Json.Serialization
Public Class Union
    <JsonPropertyName("union")>
    Public Property Union As Object
    <JsonPropertyName("intersection")>
    Public Property Intersection As Object
    <JsonPropertyName("discriminator")>
    Public Property Discriminator As Object
End Class
