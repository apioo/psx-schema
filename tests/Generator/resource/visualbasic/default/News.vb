Imports System.Text.Json.Serialization

' An general news entry
Public Class News
    <JsonPropertyName("config")>
    Public Property Config As Nullable(Meta)

    <JsonPropertyName("inlineConfig")>
    Public Property InlineConfig As Nullable(Dictionary(Of String, String))

    <JsonPropertyName("mapTags")>
    Public Property MapTags As Nullable(Dictionary(Of String, String))

    <JsonPropertyName("mapReceiver")>
    Public Property MapReceiver As Nullable(Dictionary(Of String, Author))

    <JsonPropertyName("tags")>
    Public Property Tags As Nullable(String())

    <JsonPropertyName("receiver")>
    Public Property Receiver As Nullable(Author())

    <JsonPropertyName("data")>
    Public Property Data As Nullable(Double()())

    <JsonPropertyName("read")>
    Public Property Read As Nullable(Boolean)

    <JsonPropertyName("author")>
    Public Property Author As Author

    <JsonPropertyName("meta")>
    Public Property Meta As Nullable(Meta)

    <JsonPropertyName("sendDate")>
    Public Property SendDate As Nullable(DateOnly)

    <JsonPropertyName("readDate")>
    Public Property ReadDate As Nullable(DateTime)

    <JsonPropertyName("price")>
    Public Property Price As Nullable(Double)

    <JsonPropertyName("rating")>
    Public Property Rating As Nullable(Integer)

    <JsonPropertyName("content")>
    Public Property Content As String

    <JsonPropertyName("question")>
    Public Property Question As Nullable(String)

    <JsonPropertyName("version")>
    Public Property Version As Nullable(String)

    <JsonPropertyName("coffeeTime")>
    Public Property CoffeeTime As Nullable(TimeOnly)

    <JsonPropertyName("g-recaptcha-response")>
    Public Property Captcha As Nullable(String)

    <JsonPropertyName("media.fields")>
    Public Property MediaFields As Nullable(String)

    <JsonPropertyName("payload")>
    Public Property Payload As Nullable(Object)

End Class

