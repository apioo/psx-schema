// Represents a base type. Every type extends from this common type and shares the defined properties
type CommonType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
}

// Represents a struct type. A struct type contains a fix set of defined properties
type StructType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
    Final bool `json:"$final"`
    Extends string `json:"$extends"`
    Properties Properties `json:"properties"`
    Required []string `json:"required"`
}

// Properties of a struct
type Properties = map[string]interface{}

// Represents a map type. A map type contains variable key value entries of a specific type
type MapType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
    AdditionalProperties interface{} `json:"additionalProperties"`
    MaxProperties int `json:"maxProperties"`
    MinProperties int `json:"minProperties"`
}

// Represents an array type. An array type contains an ordered list of a specific type
type ArrayType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
    Items interface{} `json:"items"`
    MaxItems int `json:"maxItems"`
    MinItems int `json:"minItems"`
}

// Represents a scalar type
type ScalarType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
    Format string `json:"format"`
    Enum []interface{} `json:"enum"`
    Default interface{} `json:"default"`
}

// Represents a boolean type
type BooleanType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
    Format string `json:"format"`
    Enum []interface{} `json:"enum"`
    Default interface{} `json:"default"`
}

// Represents a number type (contains also integer)
type NumberType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
    Format string `json:"format"`
    Enum []interface{} `json:"enum"`
    Default interface{} `json:"default"`
    MultipleOf float64 `json:"multipleOf"`
    Maximum float64 `json:"maximum"`
    ExclusiveMaximum bool `json:"exclusiveMaximum"`
    Minimum float64 `json:"minimum"`
    ExclusiveMinimum bool `json:"exclusiveMinimum"`
}

// Represents a string type
type StringType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
    Format string `json:"format"`
    Enum []interface{} `json:"enum"`
    Default interface{} `json:"default"`
    MaxLength int `json:"maxLength"`
    MinLength int `json:"minLength"`
    Pattern string `json:"pattern"`
}

// Represents an any type
type AnyType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
}

// Represents an intersection type
type IntersectionType struct {
    Description string `json:"description"`
    AllOf []ReferenceType `json:"allOf"`
}

// Represents an union type. An union type can contain one of the provided types
type UnionType struct {
    Description string `json:"description"`
    Discriminator Discriminator `json:"discriminator"`
    OneOf []interface{} `json:"oneOf"`
}

// An object to hold mappings between payload values and schema names or references
type DiscriminatorMapping = map[string]string

// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
type Discriminator struct {
    PropertyName string `json:"propertyName"`
    Mapping DiscriminatorMapping `json:"mapping"`
}

// Represents a reference type. A reference type points to a specific type at the definitions map
type ReferenceType struct {
    Ref string `json:"$ref"`
    Template TemplateProperties `json:"$template"`
}

type TemplateProperties = map[string]string

// Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
type GenericType struct {
    Generic string `json:"$generic"`
}

// The definitions map which contains all types
type Definitions = map[string]interface{}

// Contains external definitions which are imported. The imported schemas can be used via the namespace i.e. 'my_namespace:my_type'
type Import = map[string]string

// The root TypeSchema
type TypeSchema struct {
    Import Import `json:"$import"`
    Definitions Definitions `json:"definitions"`
    Ref string `json:"$ref"`
}
