// Represents an any type
type AnyType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
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

// Represents a boolean type
type BooleanType struct {
    Format string `json:"format"`
    Enum []interface{} `json:"enum"`
    Default interface{} `json:"default"`
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
}

// Represents a base type. Every type extends from this common type and shares the defined properties
type CommonType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
}

// Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description
type Discriminator struct {
    PropertyName string `json:"propertyName"`
    Mapping map[string]string `json:"mapping"`
}

// Represents a generic type. A generic type can be used i.e. at a map or array which then can be replaced on reference via the $template keyword
type GenericType struct {
    Generic string `json:"$generic"`
}

// Represents an intersection type
type IntersectionType struct {
    Description string `json:"description"`
    AllOf []ReferenceType `json:"allOf"`
}

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

// Represents a number type (contains also integer)
type NumberType struct {
    Format string `json:"format"`
    Enum []interface{} `json:"enum"`
    Default interface{} `json:"default"`
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
    MultipleOf float64 `json:"multipleOf"`
    Maximum float64 `json:"maximum"`
    ExclusiveMaximum bool `json:"exclusiveMaximum"`
    Minimum float64 `json:"minimum"`
    ExclusiveMinimum bool `json:"exclusiveMinimum"`
}

// Represents a reference type. A reference type points to a specific type at the definitions map
type ReferenceType struct {
    Ref string `json:"$ref"`
    Template map[string]string `json:"$template"`
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

// Represents a struct type. A struct type contains a fix set of defined properties
type StructType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Deprecated bool `json:"deprecated"`
    Readonly bool `json:"readonly"`
    Final bool `json:"$final"`
    Extends string `json:"$extends"`
    Properties map[string]interface{} `json:"properties"`
    Required []string `json:"required"`
}

// The root TypeSchema
type TypeSchema struct {
    Import map[string]string `json:"$import"`
    Definitions map[string]interface{} `json:"definitions"`
    Ref string `json:"$ref"`
}

// Represents an union type. An union type can contain one of the provided types
type UnionType struct {
    Description string `json:"description"`
    Discriminator Discriminator `json:"discriminator"`
    OneOf []interface{} `json:"oneOf"`
}
