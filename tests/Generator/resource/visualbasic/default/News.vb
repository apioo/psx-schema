Imports System.Text.Json.Serialization

' An general news entry
Public Class News
    <JsonPropertyName("config")>
    Public Property Config As Meta

    <JsonPropertyName("inlineConfig")>
    Public Property InlineConfig As Dictionary(Of String, String)

    <JsonPropertyName("mapTags")>
    Public Property MapTags As Dictionary(Of String, String)

    <JsonPropertyName("mapReceiver")>
    Public Property MapReceiver As Dictionary(Of String, Author)

    <JsonPropertyName("tags")>
    Public Property Tags As String()

    <JsonPropertyName("receiver")>
    Public Property Receiver As Author()

    <JsonPropertyName("data")>
    Public Property Data As Double()()

    <JsonPropertyName("read")>
    Public Property Read As Boolean

    <JsonPropertyName("author")>
    Public Property Author As Author

    <JsonPropertyName("meta")>
    Public Property Meta As Meta

    <JsonPropertyName("sendDate")>
    Public Property SendDate As DateOnly

    <JsonPropertyName("readDate")>
    Public Property ReadDate As DateTime

    <JsonPropertyName("price")>
    Public Property Price As Double

    <JsonPropertyName("rating")>
    Public Property Rating As Integer

    <JsonPropertyName("content")>
    Public Property Content As String

    <JsonPropertyName("question")>
    Public Property Question As String

    <JsonPropertyName("version")>
    Public Property Version As String

    <JsonPropertyName("coffeeTime")>
    Public Property CoffeeTime As TimeOnly

    <JsonPropertyName("g-recaptcha-response")>
    Public Property Captcha As String

    <JsonPropertyName("media.fields")>
    Public Property MediaFields As String

    <JsonPropertyName("payload")>
    Public Property Payload As Object

End Class

