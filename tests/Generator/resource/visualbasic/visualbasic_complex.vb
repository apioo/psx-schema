Imports System.Text.Json.Serialization

' Base definition type
Public Class DefinitionType
    <JsonPropertyName("description")>
    Public Property Description As String

    <JsonPropertyName("deprecated")>
    Public Property Deprecated As Boolean

    <JsonPropertyName("type")>
    Public Property Type As String

End Class

Imports System.Text.Json.Serialization

' Represents a struct which contains a fixed set of defined properties
Public Class StructDefinitionType
    Inherits DefinitionType
    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("parent")>
    Public Property Parent As String

    <JsonPropertyName("base")>
    Public Property Base As Boolean

    <JsonPropertyName("properties")>
    Public Property Properties As Dictionary(Of String, PropertyType)

    <JsonPropertyName("discriminator")>
    Public Property Discriminator As String

    <JsonPropertyName("mapping")>
    Public Property Mapping As Dictionary(Of String, String)

    <JsonPropertyName("template")>
    Public Property Template As Dictionary(Of String, String)

End Class

Imports System.Text.Json.Serialization

' Base type for the map and array collection type
Public Class CollectionDefinitionType
    Inherits DefinitionType
    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("schema")>
    Public Property Schema As PropertyType

End Class

Imports System.Text.Json.Serialization

' Represents a map which contains a dynamic set of key value entries
Public Class MapDefinitionType
    Inherits CollectionDefinitionType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

Imports System.Text.Json.Serialization

' Represents an array which contains a dynamic list of values
Public Class ArrayDefinitionType
    Inherits CollectionDefinitionType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

Imports System.Text.Json.Serialization

' Base property type
Public Class PropertyType
    <JsonPropertyName("description")>
    Public Property Description As String

    <JsonPropertyName("deprecated")>
    Public Property Deprecated As Boolean

    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("nullable")>
    Public Property Nullable As Boolean

End Class

Imports System.Text.Json.Serialization

' Base scalar property type
Public Class ScalarPropertyType
    Inherits PropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

Imports System.Text.Json.Serialization

' Represents an integer value
Public Class IntegerPropertyType
    Inherits ScalarPropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

Imports System.Text.Json.Serialization

' Represents a float value
Public Class NumberPropertyType
    Inherits ScalarPropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

Imports System.Text.Json.Serialization

' Represents a string value
Public Class StringPropertyType
    Inherits ScalarPropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("format")>
    Public Property Format As String

End Class

Imports System.Text.Json.Serialization

' Represents a boolean value
Public Class BooleanPropertyType
    Inherits ScalarPropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

Imports System.Text.Json.Serialization

' Base collection property type
Public Class CollectionPropertyType
    Inherits PropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("schema")>
    Public Property Schema As PropertyType

End Class

Imports System.Text.Json.Serialization

' Represents a map which contains a dynamic set of key value entries
Public Class MapPropertyType
    Inherits CollectionPropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

Imports System.Text.Json.Serialization

' Represents an array which contains a dynamic list of values
Public Class ArrayPropertyType
    Inherits CollectionPropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

Imports System.Text.Json.Serialization

' Represents an any value which allows any kind of value
Public Class AnyPropertyType
    Inherits PropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

End Class

Imports System.Text.Json.Serialization

' Represents a generic value which can be replaced with a dynamic type
Public Class GenericPropertyType
    Inherits PropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("name")>
    Public Property Name As String

End Class

Imports System.Text.Json.Serialization

' Represents a reference to a definition type
Public Class ReferencePropertyType
    Inherits PropertyType
    <JsonPropertyName("type")>
    Public Property Type As String

    <JsonPropertyName("target")>
    Public Property Target As String

End Class

Imports System.Text.Json.Serialization
Public Class Specification
    <JsonPropertyName("import")>
    Public Property Import As Dictionary(Of String, String)

    <JsonPropertyName("definitions")>
    Public Property Definitions As Dictionary(Of String, DefinitionType)

    <JsonPropertyName("root")>
    Public Property Root As String

End Class
