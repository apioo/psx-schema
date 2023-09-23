Imports System.Text.Json.Serialization

' Represents a base type. Every type extends from this common type and shares the defined properties
Public Class CommonType
    <JsonPropertyName("description")>
    Public Property Description As String
    <JsonPropertyName("type")>
    Public Property Type As String
    <JsonPropertyName("nullable")>
    Public Property Nullable As Boolean
    <JsonPropertyName("deprecated")>
    Public Property Deprecated As Boolean
    <JsonPropertyName("readonly")>
    Public Property Readonly As Boolean
End Class

Imports System.Text.Json.Serialization

' Represents an any type
Public Class AnyType
    Inherits CommonType
    <JsonPropertyName("type")>
    Public Property Type As String
End Class

Imports System.Text.Json.Serialization

' Represents an array type. An array type contains an ordered list of a specific type
Public Class ArrayType
    Inherits CommonType
    <JsonPropertyName("type")>
    Public Property Type As String
    <JsonPropertyName("items")>
    Public Property Items As Object
    <JsonPropertyName("maxItems")>
    Public Property MaxItems As Integer
    <JsonPropertyName("minItems")>
    Public Property MinItems As Integer
End Class

Imports System.Text.Json.Serialization

' Represents a scalar type
Public Class ScalarType
    Inherits CommonType
    <JsonPropertyName("format")>
    Public Property Format As String
    <JsonPropertyName("enum")>
    Public Property _Enum As Object()
    <JsonPropertyName("default")>
    Public Property _Default As Object
End Class

Imports System.Text.Json.Serialization

' Represents a boolean type
Public Class BooleanType
    Inherits ScalarType
    <JsonPropertyName("type")>
    Public Property Type As String
End Class

Imports System.Text.Json.Serialization
Imports System.Collections.Generic

' Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
Public Class Discriminator
    <JsonPropertyName("propertyName")>
    Public Property PropertyName As String
    <JsonPropertyName("mapping")>
    Public Property Mapping As Dictionary(Of String, String)
End Class

Imports System.Text.Json.Serialization

' Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
Public Class GenericType
    <JsonPropertyName("$generic")>
    Public Property Generic As String
End Class

Imports System.Text.Json.Serialization

' Represents an intersection type
Public Class IntersectionType
    <JsonPropertyName("description")>
    Public Property Description As String
    <JsonPropertyName("allOf")>
    Public Property AllOf As ReferenceType()
End Class

Imports System.Text.Json.Serialization

' Represents a map type. A map type contains variable key value entries of a specific type
Public Class MapType
    Inherits CommonType
    <JsonPropertyName("type")>
    Public Property Type As String
    <JsonPropertyName("additionalProperties")>
    Public Property AdditionalProperties As Object
    <JsonPropertyName("maxProperties")>
    Public Property MaxProperties As Integer
    <JsonPropertyName("minProperties")>
    Public Property MinProperties As Integer
End Class

Imports System.Text.Json.Serialization

' Represents a number type (contains also integer)
Public Class NumberType
    Inherits ScalarType
    <JsonPropertyName("type")>
    Public Property Type As String
    <JsonPropertyName("multipleOf")>
    Public Property MultipleOf As Double
    <JsonPropertyName("maximum")>
    Public Property Maximum As Double
    <JsonPropertyName("exclusiveMaximum")>
    Public Property ExclusiveMaximum As Boolean
    <JsonPropertyName("minimum")>
    Public Property Minimum As Double
    <JsonPropertyName("exclusiveMinimum")>
    Public Property ExclusiveMinimum As Boolean
End Class

Imports System.Text.Json.Serialization
Imports System.Collections.Generic

' Represents a reference type. A reference type points to a specific type at the definitions map
Public Class ReferenceType
    <JsonPropertyName("$ref")>
    Public Property Ref As String
    <JsonPropertyName("$template")>
    Public Property Template As Dictionary(Of String, String)
End Class

Imports System.Text.Json.Serialization

' Represents a string type
Public Class StringType
    Inherits ScalarType
    <JsonPropertyName("type")>
    Public Property Type As String
    <JsonPropertyName("maxLength")>
    Public Property MaxLength As Integer
    <JsonPropertyName("minLength")>
    Public Property MinLength As Integer
    <JsonPropertyName("pattern")>
    Public Property Pattern As String
End Class

Imports System.Text.Json.Serialization
Imports System.Collections.Generic

' Represents a struct type. A struct type contains a fix set of defined properties
Public Class StructType
    Inherits CommonType
    <JsonPropertyName("$final")>
    Public Property Final As Boolean
    <JsonPropertyName("$extends")>
    Public Property Extends As String
    <JsonPropertyName("type")>
    Public Property Type As String
    <JsonPropertyName("properties")>
    Public Property Properties As Dictionary(Of String, Object)
    <JsonPropertyName("required")>
    Public Property Required As String()
End Class

Imports System.Text.Json.Serialization
Imports System.Collections.Generic

' The root TypeSchema
Public Class TypeSchema
    <JsonPropertyName("$import")>
    Public Property Import As Dictionary(Of String, String)
    <JsonPropertyName("definitions")>
    Public Property Definitions As Dictionary(Of String, Object)
    <JsonPropertyName("$ref")>
    Public Property Ref As String
End Class

Imports System.Text.Json.Serialization

' Represents an union type. An union type can contain one of the provided types
Public Class UnionType
    <JsonPropertyName("description")>
    Public Property Description As String
    <JsonPropertyName("discriminator")>
    Public Property Discriminator As Discriminator
    <JsonPropertyName("oneOf")>
    Public Property OneOf As Object()
End Class
